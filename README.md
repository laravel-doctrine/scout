# Laravel Doctrine Scout

```
'providers' => [
    LaravelDoctrine\Scout\ScoutServiceProvider::class`
]
```

To index all records of a certain entity:

```
php artisan doctrine:scout:import "App\Post"
```

```
class PostRepository extends LaravelDoctrine\Scout\SearchableRepository {

}
```

```
$repository->search('Hello World')->get();
```