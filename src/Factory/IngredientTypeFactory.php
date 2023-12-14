<?php

namespace App\Factory;

use App\Entity\IngredientType;
use App\Repository\IngredientTypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<IngredientType>
 *
 * @method        IngredientType|Proxy create(array|callable $attributes = [])
 * @method static IngredientType|Proxy createOne(array $attributes = [])
 * @method static IngredientType|Proxy find(object|array|mixed $criteria)
 * @method static IngredientType|Proxy findOrCreate(array $attributes)
 * @method static IngredientType|Proxy first(string $sortedField = 'id')
 * @method static IngredientType|Proxy last(string $sortedField = 'id')
 * @method static IngredientType|Proxy random(array $attributes = [])
 * @method static IngredientType|Proxy randomOrCreate(array $attributes = [])
 * @method static IngredientTypeRepository|RepositoryProxy repository()
 * @method static IngredientType[]|Proxy[] all()
 * @method static IngredientType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static IngredientType[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static IngredientType[]|Proxy[] findBy(array $attributes)
 * @method static IngredientType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static IngredientType[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class IngredientTypeFactory extends ModelFactory
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
            'ingredientTpName' => mb_convert_case(self::faker()->text(30), MB_CASE_TITLE, 'UTF-8'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(IngredientType $ingredientType): void {})
        ;
    }

    protected static function getClass(): string
    {
        return IngredientType::class;
    }
}
