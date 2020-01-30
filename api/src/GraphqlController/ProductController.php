<?php


namespace App\GraphqlController;


use App\Entity\Option;
use App\Entity\Product;
use App\Repository\CompanyRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;

class ProductController
{
    private EntityManagerInterface $em;
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $companyRepository;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $em, CompanyRepository $companyRepository, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->companyRepository = $companyRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Mutation()
     */
    public function createProduct(Product $product): Product
    {
        $this->em->persist($product);
        foreach ($product->getOptions() as $option) {
            $this->em->persist($option);
        }
        $this->em->flush();
        return $product;
    }

    /**
     * @Query()
     */
    public function getProduct(int $productId): ?Product
    {
        return $this->productRepository->find($productId);
    }

    /**
     * @Factory()
     * @param Option[] $options
     */
    public function productFactory(string $name, float $price, int $companyId, array $options = []): Product
    {
        $product = new Product($name, $this->companyRepository->find($companyId));
        $product->setPrice($price);
        foreach ($options as $option) {
            $product->addOption($option);
        }
        return $product;
    }

    /**
     * @Factory()
     */
    public function optionFactory(string $name, float $price): Option
    {
        return new Option($name, $price);
    }
}
