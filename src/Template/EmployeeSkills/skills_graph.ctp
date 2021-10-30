<div class="row">
    <div class="col-12 remove-padding">
        <div class="card">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Skills graph
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                        <?php if(isset($years)){ ?>
                        <?= $this->Form->create() ?>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <?= $this->Form->control('year', ['label'=>false,'onchange'=>"",'class' => 'form-control','id'=>'year','required'=>'required','options'=>$years,'default'=>$default_year,'type'=>'select','empty'=>'Choose']);?>
                            </div>
                            <div class="col-md-2">
                                <?= $this->Form->button(__('Get graph'),['class' => 'btn btn-info']) ?>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                        <?php } ?>
                        <?php if($data){ ?>
                            <canvas id="myChart" width="900" height="703" class="chartjs-render-monitor" style="display: block; height: 563px; width: 900px;"></canvas>
                        <?php }else{ ?>
                        <h2>Skills data is not added</h2>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="card">
                    <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Collapsible Group Item #2
                        </button>
                    </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        Anim pariatur
                    </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php
    echo $this->Html->script('../dist/js/chart.min.js');
    echo $this->Html->script('../dist/js/chart.bundle.min.js');
    echo $this->Html->script('../dist/js/chart.bundle.js');
    echo $this->Html->css('../dist/css/chart.min');
?>
<script>
var label = <?= json_encode($label); ?>;
var data = <?= json_encode($data); ?>;
var year = <?= json_encode($default_year); ?>;
var lineChartData = {
    labels: [year+'-1-1',year+'-2-1',year+'-3-1',year+'-4-1',year+'-5-1',year+'-6-1',year+'-7-1',year+'-8-1',year+'-9-1',year+'-10-1',year+'-11-1',year+'-12-1'],
    datasets: [],
    };
for (var key in label) {
    lineChartData.datasets.push(getDataset(label[key],data[key]));
    };
function getDataset(index,data){
    var rgb_val=random_rgba();
    return{
        label: label[key],
        data: data,
        fill: false,
        borderColor: rgb_val,
        backgroundColor: rgb_val,
        borderWidth: 1,
        pointRadius: 8,
        pointHoverRadius: 12,
    };
}

var ctx = document.getElementById("myChart").getContext("2d");
ctx.height = 500;
var myChart = new Chart(ctx, {
  type: 'line',
  data: lineChartData,
  options: {
    responsive: true,
    scales: {
      xAxes: [{
        scaleLabel: {
							display: true,
							labelString: 'Month'
						},
        type: 'time',
        time: {
            unit: 'month',
        }
      }],
      yAxes: [{
        scaleLabel: {
							display: true,
							labelString: 'Skill Level'
						},
               ticks: {
                  min: 0,
                  stepSize: 1,
                  max: 7,
                  callback: function (label, index, labels) {
                                switch (label) {
                                    case 1:
                                        return 'onboarding( '+label+' )';
                                    case 2:
                                        return 'goals( '+label+' )';
                                    case 3:
                                        return 'learning( '+label+' )';
                                    case 4:
                                        return 'intern( '+label+' )';
                                    case 5:
                                        return 'beginner( '+label+' )';
                                    case 6:
                                        return 'intermediate( '+label+' )';
                                    case 7:
                                        return 'expertise( '+label+' )';
                                }
                        },
              }
            }]
    }
  }
});
function random_rgba() {
    var lum = -0.25;
    var hex = String('#' + Math.random().toString(16).slice(2, 8).toUpperCase()).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    var rgb = "#",
        c, i;
    for (i = 0; i < 3; i++) {
        c = parseInt(hex.substr(i * 2, 2), 16);
        c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
        rgb += ("00" + c).substr(c.length);
    }
    return rgb;
}
	</script>
