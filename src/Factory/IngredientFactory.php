<?php

namespace App\Factory;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Ingredient>
 *
 * @method        Ingredient|Proxy create(array|callable $attributes = [])
 * @method static Ingredient|Proxy createOne(array $attributes = [])
 * @method static Ingredient|Proxy find(object|array|mixed $criteria)
 * @method static Ingredient|Proxy findOrCreate(array $attributes)
 * @method static Ingredient|Proxy first(string $sortedField = 'id')
 * @method static Ingredient|Proxy last(string $sortedField = 'id')
 * @method static Ingredient|Proxy random(array $attributes = [])
 * @method static Ingredient|Proxy randomOrCreate(array $attributes = [])
 * @method static IngredientRepository|RepositoryProxy repository()
 * @method static Ingredient[]|Proxy[] all()
 * @method static Ingredient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Ingredient[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Ingredient[]|Proxy[] findBy(array $attributes)
 * @method static Ingredient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Ingredient[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class IngredientFactory extends ModelFactory
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
            'avgUnitWeight' => self::faker()->randomFloat(),
            'countable' => self::faker()->boolean(),
            'ingredientName' => self::faker()->text(50),
            'kgPrice' => self::faker()->randomFloat(),
        ];

        /*
        $isLiquid = self::faker()->boolean(); // Randomly determine if it's a liquid

        $defaults = [
            'avgUnitWeight' => $isLiquid ? null : self::faker()->randomFloat(),
            'avgUnitVolume' => $isLiquid ? self::faker()->randomFloat() : null,
            'countable' => self::faker()->boolean(),
            'ingredientName' => self::faker()->text(50),
            'kgPrice' => self::faker()->randomFloat(),
        ];

        return $defaults;
        */
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Ingredient $ingredient): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Ingredient::class;
    }
}
