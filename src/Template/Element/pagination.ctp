<div class="paginator dataTables_wrapper">
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
	    	<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}},showing {{current}} record(s) out of {{count}} total ')]) ?></p>
	    </div>
    	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
	    	<ul class="pagination dataTables_paginate">
	        <li class="prev"><?= $this->Paginator->prev('< ' . __('previous')) ?></li>
	        <li class="active"> <?= $this->Paginator->numbers(
				// [
				// 	'url' => [
				// 		'?' => [
				// 			'branch' => $branch,
				// 			"keyword"=>$keyword
				// 		],
						
				// 	]
				// ]
			) ?></li>
	        <li class="next"><?= $this->Paginator->next(__('next') . ' >') ?></li>
	        <li class="last"><?= $this->Paginator->last(__('last') . ' >>') ?></li>
	    </ul>
	    </div>
	    
    </div>
</div>
