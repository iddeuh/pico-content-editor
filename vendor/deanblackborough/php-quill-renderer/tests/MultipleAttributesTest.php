<?php

require_once __DIR__ . '../../src/Render.php';
require_once __DIR__ . '../../src/Renderer/Render.php';
require_once __DIR__ . '../../src/Renderer/Html.php';
require_once __DIR__ . '../../src/Parser/Parse.php';
require_once __DIR__ . '../../src/Parser/Html.php';

/**
 * Test multiple replacement
 */
final class MultipleAttributesTest extends \PHPUnit\Framework\TestCase
{
    private $deltas_multiple_attributes = '{"ops":[{"insert":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed efficitur nibh tempor augue lobortis, nec eleifend velit venenatis. Nullam fringilla dui eget lectus mattis tincidunt. \nDonec sollicitudin, lacus sed luctus ultricies, "},{"attributes":{"strike":true,"italic":true},"insert":"quam sapien "},{"attributes":{"strike":true},"insert":"sollicitudin"},{"insert":" quam, nec auctor eros felis elementum quam. Fusce vel mollis enim. "},{"attributes":{"bold":true},"insert":"Sed ac augue tincidunt,"},{"insert":" cursus urna a, tempus ipsum. Donec pretium fermentum erat a "},{"attributes":{"underline":true},"insert":"elementum"},{"insert":". In est odio, mattis sed dignissim sed, porta ac nisl. Nunc et tellus imperdiet turpis placerat tristique nec quis justo. Aenean nisi libero, auctor a laoreet sed, fermentum vel massa. Etiam ultricies leo eget purus tempor dapibus. Integer ac sapien eros. Suspendisse convallis ex."}]}';

    public function testValidDeltasMultipleAttributes()
    {
        try {
            $quill = new \DBlackborough\Quill\Render($this->deltas_multiple_attributes, 'HTML');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail(__METHOD__ . ' failure');
        }
    }

    public function testOutputMultipleAttributes()
    {
        $expected = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed efficitur nibh tempor augue lobortis, nec eleifend velit venenatis. Nullam fringilla dui eget lectus mattis tincidunt. Donec sollicitudin, lacus sed luctus ultricies, <s><em>quam sapien </em></s><s>sollicitudin</s> quam, nec auctor eros felis elementum quam. Fusce vel mollis enim. <strong>Sed ac augue tincidunt,</strong> cursus urna a, tempus ipsum. Donec pretium fermentum erat a <u>elementum</u>. In est odio, mattis sed dignissim sed, porta ac nisl. Nunc et tellus imperdiet turpis placerat tristique nec quis justo. Aenean nisi libero, auctor a laoreet sed, fermentum vel massa. Etiam ultricies leo eget purus tempor dapibus. Integer ac sapien eros. Suspendisse convallis ex.</p>";

        $quill = new \DBlackborough\Quill\Render($this->deltas_multiple_attributes);
        $this->assertEquals($expected, $quill->render());
    }

    /**
     * Test for bug report #30
     */
    public function testParagraphThenList()
    {
        $deltas = '{"ops":[{"insert":"This is a single line of text.\nBullet 1"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Bullet 2"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Bullet 3"},{"attributes":{"list":"bullet"},"insert":"\n"}]}';

        $expected = '<p>This is a single line of text.</p><ul><li>Bullet 1</li><li>Bullet 2</li><li>Bullet 3</li></ul>';

        $quill = new \DBlackborough\Quill\Render($deltas);
        $this->assertEquals($expected, $quill->render());
    }
}
