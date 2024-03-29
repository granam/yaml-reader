<?php declare(strict_types=1);

namespace Granam\Tests\YamlReader;

use Granam\YamlReader\YamlReader;
use PHPUnit\Framework\TestCase;

class YamlReaderTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_get_values(): void
    {
        $yaml = new YamlReader(<<<YAML
foo: bar
baz:
  qux: true
YAML
        );
        self::assertSame(['foo' => 'bar', 'baz' => ['qux' => true]], $yaml->getValues());
        foreach (['foo' => 'bar', 'baz' => ['qux' => true]] as $key => $value) {
            self::assertArrayHasKey($key, $yaml);
            self::assertSame($value, $yaml[$key]);
        }
    }

    /**
     * @test
     */
    public function I_can_not_set_value_on_yaml_object(): void
    {
        $this->expectException(\Granam\YamlReader\Exceptions\YamlObjectContentIsReadOnly::class);
        try {
            $yaml = new YamlReader(<<<YAML
foo: bar
baz:
  qux: true
YAML
            );
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getMessage());
        }
        $yaml['foo'] = 'bar';
    }

    /**
     * @test
     */
    public function I_can_not_remove_value_on_yaml_object(): void
    {
        $this->expectException(\Granam\YamlReader\Exceptions\YamlObjectContentIsReadOnly::class);
        try {
            $yaml = new YamlReader(<<<YAML
foo: bar
baz:
  qux: true
YAML
            );
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getMessage());
        }
        unset($yaml['foo']);
    }

}
