# Rslaravelsearch

A package for filtering laravel eloquent models

### 1. Installation
##### 1.1 Install package
```bash
composer require rohos/rslaravelsearch
```
##### 1.2 Add service providers in config/app.php
```php
Rohos\Rslaravelsearch\RslaravelsearchServiceProvider::class
```
##### 1.3 Publish the package's config
```bash
php artisan vendor:publish --tag=rslaravelsearch_config
```

### 2. Using
##### 2.1 Change config/rslaravelsearch.php if you need
##### 2.2 Create model
```php
    // For example create 2 tables
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->string('pagetitle');
        $table->boolean('published')->default(1)->index();
        $table->unsignedInteger('author_id');
        $table->text('content');
        $table->timestamps();

        $table->foreign('author_id', 'author_id_f_posts')
            ->references('id')
            ->on('users');
    });
```
##### 2.3 Simple search
Now for search posts 
```php
    $post = new \App\Post;
    // Create array or $request->all()
    $data = [
        'published' => 1,
        'author_id' => 5
    ];

    // Return 
    $posts = $post->rssearch($data)->get();
    $postsWithCount = $post->rssearchWithCount($data);
```
First create class PostSimpleSearch. This class must extends QueryFilter, and create public methods with name = config "mtd_prefix" + key_field_from_data. If you want search by field published - method named "_published()"
```php
namespace App;
// This class need be extends
use Rohos\Rslaravelsearch\QueryFilter;

class PostSimpleSearch extends QueryFilter
{
    // Public method - find by field published (mtd_prefix + field)
    public function _published($flag)
    {
        $this->builder->where('published', $flag ? 1 : 0);
    }

    // Public method - find by field author_id (mtd_prefix + field)
    public function _author_id($id)
    {
        $this->builder->where('author_id', intval($id));
    }
}
```

Next create models User and Post. For search posts need use trait Rssearchable, and create protected method "rssearchDefaultEntity()"
```php
namespace App;

use App\Rssearchers\PostSimpleSearch;
use Illuminate\Database\Eloquent\Model;
use Rohos\Rslaravelsearch\Traits\Rssearchable;

class Post extends Model
{
    use Rssearchable;

    protected function rssearchDefaultEntity()
    {
        return PostSimpleSearch::class;
    }
}
```
That's all

##### 2.3 A more complex search
For example search by user field
```php
    $post = new \App\Post;
    $entity = 'withUser';
    // Create array or $request->all()
    $data = [
        'published' => 1,
        'email' => "John@doe.com"
    ];

    // Return 
    $posts = $post->rssearch($data, $entity)->get();
    $postsWithCount = $post->rssearchWithCount($data, $entity);
```
Add a relationship for Post model and new search entity PostSearch
```php
namespace App;

// This is new search entity
use App\Rssearchers\PostSearch;
use App\Rssearchers\PostSimpleSearch;
use Illuminate\Database\Eloquent\Model;
use Rohos\Rslaravelsearch\Traits\Rssearchable;

class Post extends Model
{
    use Rssearchable;

    // Add relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected function rssearchDefaultEntity()
    {
        return PostSimpleSearch::class;
    }

    // Set the list of search classes
    protected function setRssearchEntity()
    {
        $this->rssearchesEntities['withUser'] = PostSearch::class;
    }
}
```
Create new search class PostSearch
```php
namespace App;

use Rohos\Rslaravelsearch\QueryFilter;

class PostSearch extends QueryFilter
{
    protected $defaultGetFields = ['posts.*'];
    protected $defaultCountFields = 'posts.id';

    protected function beforeSearch()
    {
        $this->builder->with('user');
        $this->builder->leftJoin('users', 'users.id', '=', 'posts.author_id');
    }

    public function _published($flag)
    {
        $this->builder->where('posts.published', $flag ? 1 : 0);
    }

    public function _email($email)
    {
        $this->builder->where('users.email', 'LIKE', trim($email) .'%');
    }

    public function _author_id($id)
    {
        $this->builder->where('posts.author_id', intval($id));
    }
}
```
That's all