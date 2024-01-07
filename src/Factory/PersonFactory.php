<?php

namespace App\Factory;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Person>
 *
 * @method        Person|Proxy                     create(array|callable $attributes = [])
 * @method static Person|Proxy                     createOne(array $attributes = [])
 * @method static Person|Proxy                     find(object|array|mixed $criteria)
 * @method static Person|Proxy                     findOrCreate(array $attributes)
 * @method static Person|Proxy                     first(string $sortedField = 'id')
 * @method static Person|Proxy                     last(string $sortedField = 'id')
 * @method static Person|Proxy                     random(array $attributes = [])
 * @method static Person|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PersonRepository|RepositoryProxy repository()
 * @method static Person[]|Proxy[]                 all()
 * @method static Person[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Person[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Person[]|Proxy[]                 findBy(array $attributes)
 * @method static Person[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Person[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PersonFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->unique()->numerify('user-###').'@'.self::faker()->domainName(),
            'inventory' => InventoryFactory::new(),
            'password' => 'test',
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Person $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Person::class;
    }
}
