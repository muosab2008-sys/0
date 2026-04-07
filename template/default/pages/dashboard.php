<?php
	if(! defined('BASEPATH') ){ exit('Unable to view file.'); }

	// Load Sidebar
	require(BASE_PATH.'/template/'.$config['theme'].'/common/sidebar.php');
	
	// Page Data
	$leads = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `completed_offers` WHERE `user_id`='".$data['id']."'");
	$referrals = $db->QueryFetchArray("SELECT COUNT(*) AS `total` FROM `users` WHERE `ref`='".$data['id']."'");
	$stats_leads = $db->QueryFetchArrayAll("SELECT COUNT(*) AS `total`, DATE(FROM_UNIXTIME(`timestamp`)) AS `day` FROM `completed_offers` WHERE `user_id`='".$data['id']."' GROUP BY `day` ORDER BY `day` DESC LIMIT 7");
	$pending_reward = $db->QueryFetchArray("SELECT SUM(`reward`) AS `total` FROM `completed_offers` WHERE `user_id`='".$data['id']."' AND `status`='0'");
	
	$dates = array();
	$graphDates = array();
	for ($i = 0; $i < 7; $i++) {
		$dates[] = date('Y-m-d', time() - 86400 * $i);
		$graphDates[] = '"'.date('Y-m-d', time() - 86400 * $i).'"';
	}
	$dates = array_reverse($dates);
	$graphDates = array_reverse($graphDates);
	$graphDates = implode(',', $graphDates);
	
	$dailyLeads = array();
	foreach($dates as $date) {
		$result = 0;
		foreach($stats_leads as $stat) {
			if($date == $stat['day']) {
				$result = $stat['total'];
			}
		}

		$dailyLeads[] = $result;
	}
	
	$dailyLeads = implode(',', $dailyLeads);
?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <section class="section dashboard">
      <div class="row">
		<?php
			if($proxy)
			{
				echo '<div class="col-12"><div class="alert alert-warning text-center" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> <b>WARNING</b> <i class="bi bi-exclamation-triangle-fill"></i><br />You\'ve been detected using VPN / Proxy server, which is forbidden as per our <a href="'.GenerateURL('tos').'">Terms of Service</a>.<br />Please disable your VPN / Proxy service, otherwise your account will be permanently suspended and your earnings will be voided.</div></div>';
			}
		?>
		<div class="col-xxl-3 col-md-6">
		  <div class="card info-card sales-card">
			<div class="card-body">
			  <h5 class="card-title">Account Balance</h5>
			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
				  <i class="bi bi-x-diamond-fill"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo number_format($data['account_balance'], 2); ?></h6>
				  <span class="text-muted small pt-2 ps-1">Available Coins</span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="col-xxl-3 col-md-6">
		  <div class="card info-card revenue-card">
			<div class="card-body">
			  <h5 class="card-title">Pending Earnings</span></h5>
			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
				  <i class="bi bi-x-diamond"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo number_format($pending_reward['total'], 2); ?></h6>
				  <span class="text-muted small pt-2 ps-1">Pending Coins</span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="col-xxl-3 col-md-6">
		  <div class="card info-card sales-card">
			<div class="card-body">
			  <h5 class="card-title">Completed Offers</h5>
			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
				  <i class="bi bi-menu-button-wide"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo number_format($leads['total']); ?></h6>
				  <span class="text-muted small pt-2 ps-1">Transactions</span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="col-xxl-3 col-xl-12">
		  <div class="card info-card customers-card">
			<div class="card-body">
			  <h5 class="card-title">Referrals</h5>
			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
				  <i class="bi bi-people-fill"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo number_format($referrals['total']); ?></h6>
				  <span class="text-muted small pt-2 ps-1">Referrals</span>
				</div>
			  </div>
			</div>
		  </div>
		</div>
        <div class="col-lg-8">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Completed Offers <span>| Reports</span></h5>
                  <div id="reportsChart"></div>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Completed Offers',
                          data: [<?php echo $dailyLeads; ?>],
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: [<?php echo $graphDates; ?>]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy'
                          },
                        }
                      }).render();
                    });
                  </script>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Past 10 Transactions</h5>

                  <table class="table table-borderless table-sm table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Provider</th>
                        <th scope="col">Offer</th>
                        <th scope="col">Reward</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php
							$offers = $db->QueryFetchArrayAll("SELECT * FROM `completed_offers` WHERE `user_id`='".$data['id']."' ORDER BY `id` DESC LIMIT 10");
							$status = array(0 => '<span class="badge bg-info">Pending</span>', 1 => '<span class="badge bg-success">Approved</span>', 2 => '<span class="badge bg-danger">Rejected</span>', 3 => '<span class="badge bg-warning">Chargeback</span>', 4 => '<span class="badge bg-danger">Proxy / VPN</span>');
							
							foreach($offers as $offer)
							{
								echo '<tr>
									<th scope="row"><b>'.$offer['id'].'</b></th>
									<td>'.strtoupper($offer['method']).'</td>
									<td><b class="text-primary">'.(empty($offer['campaign_name']) ? 'Unknown' : $offer['campaign_name']).'</b></td>
									<td>'.$offer['reward'].' coins</td>
									<td>'.$status[$offer['status']].'</td>
								  </tr>';
							}
						?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="filter">
              <a class="icon" href="<?=GenerateURL('activities')?>">View All</a>
            </div>
            <div class="card-body">
              <h5 class="card-title">Recent Activity</h5>
              <div class="activity">
				<?php
					$activities = $db->QueryFetchArrayAll("SELECT * FROM `users_activities` WHERE `user_id`='".$data['id']."' ORDER BY `time` DESC LIMIT 5");
					if(empty($activities)) {
						echo '<div class="alert alert-light" role="alert">You don\'t have any notifications yet!</div>';
					} else {
						foreach($activities as $activity) {
							echo get_activity($activity['notify_id'], $activity['value'], $activity['time'], $activity['read'], 1);
						}
					}
				?>
              </div>
            </div>
          </div>
		  <?php
			$leads = $db->QueryFetchArrayAll("SELECT COUNT(*) AS `total`, `status` FROM `completed_offers` WHERE `user_id`='".$data['id']."' GROUP BY `status`");
		  			
			$graph = array();
			foreach($leads as $lead)
			{
				$graph[$lead['status']] = $lead['total'];
			}
			
			$pendingLeads = (isset($graph[0]) ? $graph[0] : 0);
			$approvedLeads = (isset($graph[1]) ? $graph[1] : 0);
			$chargebackLeads = (isset($graph[3]) ? $graph[3] : 0);
			$rejectedLeads = (isset($graph[2]) ? $graph[2] : 0);
			$rejectedLeads = $rejectedLeads + (isset($graph[4]) ? $graph[4] : 0);
		  ?>
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Total Transactions <span>| Reports</span></h5>
              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Transactions',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: <?php echo $pendingLeads; ?>,
                          name: 'Pending'
                        },{
                          value: <?php echo $approvedLeads; ?>,
                          name: 'Approved'
                        },
                        {
                          value: <?php echo $rejectedLeads; ?>,
                          name: 'Rejected'
                        },
                        {
                          value: <?php echo $chargebackLeads; ?>,
                          name: 'Chargeback'
                        }
                      ]
                    }]
                  });
                });
              </script>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>