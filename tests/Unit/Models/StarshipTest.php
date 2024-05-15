<?php
/**
 * @package Tests\Unit\Models
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit\Models;

use App\Models\Starship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class StarshipTest extends TestCase
{
    use RefreshDatabase;

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function fillable_exists_with_keys(): void
    {
        $starship = new Starship();

        $fillable = $starship->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('model', $fillable);
        $this->assertContains('edited', $fillable);
    }
}
