<?php

namespace Spatie\TypeScriptTransformer\Tests\Transformers;

use DateTime;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Spatie\TypeScriptTransformer\Tests\FakeClasses\SpatieEnum;
use Spatie\TypeScriptTransformer\Transformers\SpatieEnumTransformer;

class SpatieEnumTransformerTest extends TestCase
{
    private SpatieEnumTransformer $transformer;

    public function setUp(): void
    {
        parent::setUp();

        $this->transformer = new SpatieEnumTransformer();
    }

    /** @test */
    public function it_will_only_convert_enums()
    {
        $this->assertTrue($this->transformer->canTransform(
            new ReflectionClass(SpatieEnum::class)
        ));

        $this->assertFalse($this->transformer->canTransform(
            new ReflectionClass(DateTime::class)
        ));
    }

    /** @test */
    public function it_can_transform_an_enum()
    {
        $type = $this->transformer->transform(
            new ReflectionClass(SpatieEnum::class),
            'FakeEnum'
        );

        $this->assertEquals("export type FakeEnum = 'draft' | 'published' | 'archived';", $type->transformed);
        $this->assertTrue($type->missingSymbols->isEmpty());
        $this->assertFalse($type->isInline);
    }
}
