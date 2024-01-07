<?php

namespace App\Factory;

use App\Entity\RecipeQuantity;
use App\Repository\RecipeQuantityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<RecipeQuantity>
 *
 * @method        RecipeQuantity|Proxy create(array|callable $attributes = [])
 * @method static RecipeQuantity|Proxy createOne(array $attributes = [])
 * @method static RecipeQuantity|Proxy find(object|array|mixed $criteria)
 * @method static RecipeQuantity|Proxy findOrCreate(array $attributes)
 * @method static RecipeQuantity|Proxy first(string $sortedField = 'id')
 * @method static RecipeQuantity|Proxy last(string $sortedField = 'id')
 * @method static RecipeQuantity|Proxy random(array $attributes = [])
 * @method static RecipeQuantity|Proxy randomOrCreate(array $attributes = [])
 * @method static RecipeQuantityRepository|RepositoryProxy repository()
 * @method static RecipeQuantity[]|Proxy[] all()
 * @method static RecipeQuantity[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static RecipeQuantity[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static RecipeQuantity[]|Proxy[] findBy(array $attributes)
 * @method static RecipeQuantity[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RecipeQuantity[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class RecipeQuantityFactory extends ModelFactory
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
            'ingredient' => IngredientFactory::new(),
            'quantity' => self::faker()->randomFloat(),
            'recipe' => RecipeFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(RecipeQuantity $recipeQuantity): void {})
        ;
    }

    protected static function getClass(): string
    {
        return RecipeQuantity::class;
    }
}
