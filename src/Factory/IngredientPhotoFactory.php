<?php

namespace App\Factory;

use App\Entity\IngredientPhoto;
use App\Repository\IngredientPhotoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<IngredientPhoto>
 *
 * @method        IngredientPhoto|Proxy create(array|callable $attributes = [])
 * @method static IngredientPhoto|Proxy createOne(array $attributes = [])
 * @method static IngredientPhoto|Proxy find(object|array|mixed $criteria)
 * @method static IngredientPhoto|Proxy findOrCreate(array $attributes)
 * @method static IngredientPhoto|Proxy first(string $sortedField = 'id')
 * @method static IngredientPhoto|Proxy last(string $sortedField = 'id')
 * @method static IngredientPhoto|Proxy random(array $attributes = [])
 * @method static IngredientPhoto|Proxy randomOrCreate(array $attributes = [])
 * @method static IngredientPhotoRepository|RepositoryProxy repository()
 * @method static IngredientPhoto[]|Proxy[] all()
 * @method static IngredientPhoto[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static IngredientPhoto[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static IngredientPhoto[]|Proxy[] findBy(array $attributes)
 * @method static IngredientPhoto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static IngredientPhoto[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class IngredientPhotoFactory extends ModelFactory
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
        return [];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(IngredientPhoto $ingredientPhoto): void {})
        ;
    }

    protected static function getClass(): string
    {
        return IngredientPhoto::class;
    }
}
