<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!--[if !mso]><!-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--<![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <!--[if !mso]><!-->
  <style type="text/css">
    @font-face {
              font-family: 'flama-condensed';
              font-weight: 100;
              src: url('http://assets.vervewine.com/fonts/FlamaCond-Medium.eot');
              src: url('http://assets.vervewine.com/fonts/FlamaCond-Medium.eot?#iefix') format('embedded-opentype'),
                    url('http://assets.vervewine.com/fonts/FlamaCond-Medium.woff') format('woff'),
                    url('http://assets.vervewine.com/fonts/FlamaCond-Medium.ttf') format('truetype');
          }
          @font-face {
              font-family: 'Muli';
              font-weight: 100;
              src: url('http://assets.vervewine.com/fonts/muli-regular.eot');
              src: url('http://assets.vervewine.com/fonts/muli-regular.eot?#iefix') format('embedded-opentype'),
                    url('http://assets.vervewine.com/fonts/muli-regular.woff2') format('woff2'),
                    url('http://assets.vervewine.com/fonts/muli-regular.woff') format('woff'),
                    url('http://assets.vervewine.com/fonts/muli-regular.ttf') format('truetype');
            }
          .address-description a {color: #000000 ; text-decoration: none;}
          @media (max-device-width: 480px) {
            .vervelogoplaceholder {
              height:83px ;
            }
          }
  </style>
  <!--<![endif]-->
  <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        .address-description a {color: #000000 ; text-decoration: none;}
        table {border-collapse: collapse ;}
    </style>
    <![endif]-->
</head>

<body bgcolor="#e1e5e8" style="font-family: Verdana,Geneva,sans-serif; margin-top:0 ;margin-bottom:0 ;margin-right:0 ;margin-left:0 ;padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;background-color:#e1e5e8;">
  <!--[if gte mso 9]>
<center>
<table width="600" cellpadding="0" cellspacing="0"><tr><td valign="top">
<![endif]-->
  <center style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#e1e5e8;">
    <div style="max-width:600px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;">
      <table align="center" cellpadding="0" style="border-spacing:0;font-family:'Muli',Arial,sans-serif;color:#333333;Margin:0 auto;width:100%;max-width:600px;">
        <tbody>
          <tr>
            <td align="center" class="vervelogoplaceholder" height="143" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;height:143px;vertical-align:middle;" valign="middle">
                <span class="sg-image" data-imagelibrary="%7B%22width%22%3A%22160%22%2C%22height%22%3A34%2C%22alt_text%22%3A%22Verve%20Wine%22%2C%22alignment%22%3A%22%22%2C%22border%22%3A0%2C%22src%22%3A%22https%3A//marketing-image-production.s3.amazonaws.com/uploads/79d8f4f889362f0c7effb2c26e08814bb12f5eb31c053021ada3463c7b35de6fb261440fc89fa804edbd11242076a81c8f0a9daa443273da5cb09c1a4739499f.png%22%2C%22link%22%3A%22%23%22%2C%22classes%22%3A%7B%22sg-image%22%3A1%7D%7D">
                    <a href="#" target="_blank">
                        <img alt="Sj connect" height="80" src="https://connect.sjinnovation.com/img/logo/sj-connect-logo.png" style="border-width: 0px; width: 300px; height: 80px;" width="300">
                    </a>
                </span>
            </td>
          </tr>
          <!-- Start of Email Body-->
          <tr>
            <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#ffffff;">
              <!--[if gte mso 9]>
                    <center>
                    <table width="80%" cellpadding="20" cellspacing="30"><tr><td valign="top">
                    <![endif]-->
              <table style="border-spacing:0;" width="100%">
                <tbody>

                  <!-- Leave Applier name and no of days-->
                  <tr>
                    <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                      <?php if($leaveRequestFrom == '') {?>
                        <h2 style="font-family: Verdana,Geneva,sans-serif;"><?= $applierName; ?> Approved the reliver for the leave of <span style="color: YellowGreen;"><?= $no_of_days?> day/s</span></h2>
                      <?php } else { ?>
                        <h2 style="font-family: Verdana,Geneva,sans-serif;"><?= $applierName; ?> Approved the reliver of <?= $employee_name ?> for the leave of <?= $leaveRequestFrom ?> to <span style="color: YellowGreen;"><?=$no_of_days?> day/s</span></h2>
                       <?php }?>
                    </td>
                  </tr>

                  <!-- Leave days from and to date -->
                  <tr>
                    <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                      <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                        <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                      </p>
                    </td>
                  </tr>

                  <!-- Type of leave applied by the applicant -->
                  <tr>
                    <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                      <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                        <?=$leave_type; ?>
                      </p>
                    </td>
                  </tr>


                  <!-- Reliever person for the applicant. -->
                  <tr>
                    <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                      <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                          <?php
                          $selectedReliever = trim($reliever_name,",");
                          $relieverList = explode(',', $selectedReliever);
                          foreach ($relieverList as $rl) :
                              echo "<p style='font-size: 12px; display: inline'>".$this->Html->link(\App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl), ['controller' => 'Employees', 'action' => 'view', $rl])."</p>";
                              //echo \App\Model\Table\EmpLeavesTable::getEmployeeNameFromId($rl);
                              ?>

                          <?php endforeach;?>
                      </p>
                    </td>
                  </tr>

                </tbody>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td></tr></table>
                    </center>
                    <![endif]-->
            </td>
          </tr>
          <!-- End of Email Body-->
          <!-- whitespace -->
          <tr>
            <td height="40">
              <p style="line-height: 40px; padding: 0 0 0 0; margin: 0 0 0 0;">&nbsp;</p>

              <p>&nbsp;</p>
            </td>
          </tr>

          <tr>
            <td height="25">
              <p style="line-height: 25px; padding: 0 0 0 0; margin: 0 0 0 0;">&nbsp;</p>
              <p>&nbsp;</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </center>
  <!--[if gte mso 9]>
</td></tr></table>
</center>
<![endif]-->


</body>