<div class="row designation">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Salary History of <?= h($employeeName) ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Salary</th>
                                <th>Reason</th>
                                <th>Designation</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($salaries as $salary): ?>
                            <tr>
                                <td><?=h($salary->salary_amount) ?></td>
                                <td><?=h($salary->reason) ?></td>
                                <td><?= h($salary->designation['title'])?></td>
                                <td><?=date('m/d/Y',strtotime(h($salary->created))) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>    
    </div>
</div>