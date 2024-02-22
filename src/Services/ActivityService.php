<?php

namespace App\Services;


use App\Client\BoredomApiClientInterface;
use App\Object\Activity;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use App\Enum\ActivityEnum;

class ActivityService implements ActivityServiceInterface
{


    public function __construct(
        protected SerializerInterface $serializer,
        protected ValidatorInterface  $validator,
        protected BoredomApiClientInterface    $boredomApiClient
    )
    {
    }


    /**
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    public function getData(int $participants): JsonResponse
    {
        $data = $this->boredomApiClient->getActivity($participants);

        $decodeData = json_decode($data);
        $accessibility = $decodeData->accessibility;

        if ($accessibility < 0.2) {
            return new JsonResponse(['errors' => 'Repeat your request'], Response::HTTP_BAD_REQUEST);
        }
        $activity = $decodeData->activity;
        $type = $decodeData->type;
        $activityObject = new Activity();
        $activityObject->setActivity($activity)->setType($type);
        $errors = $this->validator->validate($activityObject);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['activity' => [
            ActivityEnum::Activity->value => $activityObject->getActivity(),
            ActivityEnum::Type->value => $activityObject->getType(),
            ActivityEnum::Participants->value => $participants
        ]]);
    }
}