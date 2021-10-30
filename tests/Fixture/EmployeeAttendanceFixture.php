<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeeAttendanceFixture
 *
 */
class EmployeeAttendanceFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'employee_attendance';

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
        'hours_worked' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => '00:00:00', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'extra_hours' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'late_by' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => '00:00:00', 'comment' => '', 'precision' => null],
        'early_by' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => '00:00:00', 'comment' => '', 'precision' => null],
        'is_present' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_attendence' => ['type' => 'index', 'columns' => ['employee_id'], 'length' => []],
        ],
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
                'shift_start_at' => '07:01:01',
                'shift_end_at' => '07:01:01',
                'date' => '2020-03-18',
                'checkin' => '07:01:01',
                'checkout' => '07:01:01',
                'hours_worked' => 'Lorem ipsum dolor sit amet',
                'extra_hours' => '07:01:01',
                'late_by' => '07:01:01',
                'early_by' => '07:01:01',
                'is_present' => 1,
                'created' => '2020-03-18 07:01:01',
                'modified' => '2020-03-18 07:01:01'
            ],
        ];
        parent::init();
    }
}
