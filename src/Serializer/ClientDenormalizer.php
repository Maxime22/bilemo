<?php

namespace App\Serializer;

use App\Entity\User;
use App\Repository\ClientRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class ClientDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    // implements dynamically DenormalizerAwareInterface
    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'UserOwnedDenormalizerCalled';

    private $security;
    private $clientRepository;

    public function __construct(Security $security, ClientRepository $clientRepository)
    {
        $this->security = $security;
        $this->clientRepository = $clientRepository;
    }

    // check if we call the denormalize method
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = [])
    {
        $alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return $type === User::class && !$alreadyCalled;
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED_DENORMALIZER] = true;
        // I don't want to normalize myself so i use the denormalizer interface to do it
        // I just want to add some logic to the array
        // This line call all the denormalizer in an infinite loop, we need to stop the loop if the denormalizer is already in the context
        // This is due to the fact that we call a denormalizer in a denormalizer
        $user = $this->denormalizer->denormalize($data, $type, $format, $context);

        $client = $this->clientRepository->find($this->security->getUser()->getId());
        $user->setClient($client); // we can't get directly the security cause we don't have the password in the JWT token

        return $user;
    }
}
