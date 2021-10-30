<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeeAttendancesFixture
 *
 */
class EmployeeAttendancesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'employee_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'employee_name' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'shift' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'shift_start_at' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'shift_end_at' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'checkin' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'checkout' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'hours_worked' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => '00:00:00', 'comment' => '', 'precision' => null],
        'extra_hours' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'late_by' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => '00:00:00', 'comment' => '', 'precision' => null],
        'early_by' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => '00:00:00', 'comment' => '', 'precision' => null],
        'is_present' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'employee_id' => 1,
                'employee_name' => 'Lorem ipsum dolor sit amet',
                'shift' => 'Lorem ipsum dolor sit amet',
                'shift_start_at' => '05:17:35',
                'shift_end_at' => '05:17:35',
                'date' => '2020-03-16',
                'checkin' => '05:17:35',
                'checkout' => '05:17:35',
                'hours_worked' => '05:17:35',
                'extra_hours' => '05:17:35',
                'late_by' => '05:17:35',
                'early_by' => '05:17:35',
                'is_present' => 1,
                'created' => '2020-03-16 05:17:35',
                'modified' => '2020-03-16 05:17:35'
            ],
        ];
        parent::init();
    }
}
