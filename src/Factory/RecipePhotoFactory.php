<?php

namespace App\Factory;

use App\Entity\RecipePhoto;
use App\Repository\RecipePhotoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<RecipePhoto>
 *
 * @method        RecipePhoto|Proxy create(array|callable $attributes = [])
 * @method static RecipePhoto|Proxy createOne(array $attributes = [])
 * @method static RecipePhoto|Proxy find(object|array|mixed $criteria)
 * @method static RecipePhoto|Proxy findOrCreate(array $attributes)
 * @method static RecipePhoto|Proxy first(string $sortedField = 'id')
 * @method static RecipePhoto|Proxy last(string $sortedField = 'id')
 * @method static RecipePhoto|Proxy random(array $attributes = [])
 * @method static RecipePhoto|Proxy randomOrCreate(array $attributes = [])
 * @method static RecipePhotoRepository|RepositoryProxy repository()
 * @method static RecipePhoto[]|Proxy[] all()
 * @method static RecipePhoto[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static RecipePhoto[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static RecipePhoto[]|Proxy[] findBy(array $attributes)
 * @method static RecipePhoto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RecipePhoto[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class RecipePhotoFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'recipePhoto' => file_get_contents(__DIR__.'/data/recipeNoCurrentImage.webp'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(RecipePhoto $recipePhoto): void {})
        ;
    }

    protected static function getClass(): string
    {
        return RecipePhoto::class;
    }
}
