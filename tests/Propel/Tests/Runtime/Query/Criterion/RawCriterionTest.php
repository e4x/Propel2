<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Propel\Tests\Runtime\Query\Criterion;

use Propel\Tests\Helpers\BaseTestCase;

use Propel\Runtime\Query\Criteria;
use Propel\Runtime\Query\Criterion\RawCriterion;

use \PDO;

/**
 * Test class for RawCriterion.
 *
 * @author François Zaninotto
 */
class RawCriterionTest extends BaseTestCase
{
    /**
     * @expectedException Propel\Runtime\Exception\PropelException
     */
    public function testAppendPsToThrowsExceptionWhenClauseHasNoQuestionMark()
    {
        $cton = new RawCriterion(new Criteria(), 'A.COL = BAR', 1, PDO::PARAM_INT);

        $params = array();
        $ps = '';
        $cton->appendPsTo($ps, $params);
    }

    public function testAppendPsToCreatesAPDOClauseyDefault()
    {
        $cton = new RawCriterion(new Criteria(), 'A.COL = ?', 1, PDO::PARAM_INT);

        $params = array();
        $ps = '';
        $cton->appendPsTo($ps, $params);

        $this->assertEquals('A.COL = :p1', $ps);
        $expected = array(
            array('table' => null, 'value' => 1, 'type' => PDO::PARAM_INT)
        );
        $this->assertEquals($expected, $params);
    }

    public function testAppendPsToUsesParamIntByDefault()
    {
        $cton = new RawCriterion(new Criteria(), 'A.COL = ?', 1);

        $params = array();
        $ps = '';
        $cton->appendPsTo($ps, $params);

        $this->assertEquals('A.COL = :p1', $ps);
        $expected = array(
            array('table' => null, 'value' => 1, 'type' => PDO::PARAM_STR)
        );
        $this->assertEquals($expected, $params);
    }

}
