<?php

namespace App\Factory;

use App\Entity\FridgeQuantity;
use App\Repository\FridgeQuantityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<FridgeQuantity>
 *
 * @method        FridgeQuantity|Proxy create(array|callable $attributes = [])
 * @method static FridgeQuantity|Proxy createOne(array $attributes = [])
 * @method static FridgeQuantity|Proxy find(object|array|mixed $criteria)
 * @method static FridgeQuantity|Proxy findOrCreate(array $attributes)
 * @method static FridgeQuantity|Proxy first(string $sortedField = 'id')
 * @method static FridgeQuantity|Proxy last(string $sortedField = 'id')
 * @method static FridgeQuantity|Proxy random(array $attributes = [])
 * @method static FridgeQuantity|Proxy randomOrCreate(array $attributes = [])
 * @method static FridgeQuantityRepository|RepositoryProxy repository()
 * @method static FridgeQuantity[]|Proxy[] all()
 * @method static FridgeQuantity[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static FridgeQuantity[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static FridgeQuantity[]|Proxy[] findBy(array $attributes)
 * @method static FridgeQuantity[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FridgeQuantity[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FridgeQuantityFactory extends ModelFactory
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
            'inventory' => InventoryFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(FridgeQuantity $fridgeQuantity): void {})
        ;
    }

    protected static function getClass(): string
    {
        return FridgeQuantity::class;
    }
}
