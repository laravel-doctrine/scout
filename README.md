# Laravel Doctrine Scout

```php
'providers' => [
    LaravelDoctrine\Scout\ScoutServiceProvider::class`
]
```

```
'events'     => [
    'listeners'   => [],
    'subscribers' => [
        LaravelDoctrine\Scout\Subscribers\SearachableSubscriber::class
    ]
],
```

```php
class Post implements LaravelDoctrine\Scout\Searchable
{
    use LaravelDoctrine\Scout\Indexable;
}
```

To index all records of a certain entity:

```
php artisan doctrine:scout:import "App\Post"
```

```php
class PostRepository extends LaravelDoctrine\Scout\SearchableRepository 
{
}
```

```php
$this->app->bind(PostRepository::class, function($app) {
    return new PostRepository(
        $app['em'],
        $app['em']->getClassMetadata(Post::class),
        $app->make(Laravel\Scout\EngineManager::class)
    );
});
```

```php
$repository->search('Hello World')->get();
```