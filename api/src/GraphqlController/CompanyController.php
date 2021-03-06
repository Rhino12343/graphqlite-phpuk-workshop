<?php


namespace App\GraphqlController;


use App\Entity\Company;
use App\Repository\CompanyRepository;
use Porpaginas\Doctrine\ORM\ORMQueryResult;
use Porpaginas\Result;
use TheCodingMachine\GraphQLite\Annotations\Query;

class CompanyController
{
    /**
     * @var CompanyRepository
     */
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getCompanies(?string $search)
    {
        return $this->companyRepository->search($search)->getResult();
    }

//    /**
//     * @Query()
//     * @param string|null $search
//     * @return Company[]
//     */
//    public function getCompanies(?string $search): Result
//    {
//        return new ORMQueryResult($this->companyRepository->search($search));
//    }

//    /**
//     * @Query()
//     */
//    public function getCompany(int $id): ?Company
//    {
//        return $this->companyRepository->find($id);
//    }
}
