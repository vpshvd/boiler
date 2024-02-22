<?php

namespace App\Tests\Services;

use App\Client\BoredomApiClient;
use App\Services\ActivityService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ActivityServiceTest extends KernelTestCase
{
    private MockObject $mockObject;

    private ValidatorInterface $validator;

    private SerializerInterface $serializer;
    public function setUp(): void
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->validator = Validation::createValidator();

        $this->mockObject = $this->createMock(BoredomApiClient::class);
        $data = json_encode(
            [
                'activity' => "Clean out your garage",
                'type' => 'busywork',
                'participants' => 2,
                'price' => 0,
                "link" => '',
                "key" => "7023703",
                'accessibility' => 0.3
            ]
        );
        $this->mockObject
            ->expects($this->once())
            ->method('getActivity')
            ->with(2)
            ->willReturn($data);
    }

    public function testMock()
    {

        $services = new ActivityService($this->serializer, $this->validator, $this->mockObject);
        $data = $services->getData(2);
        $this->assertNotNull($data);
    }
    public function testMockArrayHasKey ()
    {
        $services = new ActivityService($this->serializer, $this->validator, $this->mockObject);
        $data = $services->getData(2);
        $content = json_decode($data->getContent());
        $array = (array) $content->activity;
        $this->assertArrayHasKey('activity', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('participants', $array);
    }
}
