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
                        <img alt="Verve Wine" height="80" src="https://connect.sjinnovation.com/img/logo/sj-connect-logo.png" style="border-width: 0px; width: 300px; height: 80px;" width="300">
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
                    <!--     For Sylhet -->
                    <div style="margin-bottom: 10px; border: 1px solid #000000">
                        <table style="border-spacing:0; padding: 5px" width="100%">
                            <tbody>
                            <tr>
                                <td align="center" class="inner heading-table" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                    <h2 style="font-family: Verdana,Geneva,sans-serif;">Total leave from Sylhet : <span style="color: YellowGreen;"><?=$totalLeavesFromSylCount?></span></h2>
                                </td>
                            </tr>

                            <?php
                            foreach ($totalLeavesFromSyl as $leave)
                            {
                                if($leave->leave_type == '1')
                                {
                                    $ltype = "Sick Leave";
                                }
                                else if($leave->leave_type == '2')
                                {
                                    $ltype = "Casual Leave";
                                }
                                else if($leave->leave_type == '4')
                                {
                                    $ltype = "Earned Leave";
                                }
                                else if($leave->leave_type == '5')
                                {
                                    $ltype = "Unplanned Leave";
                                }
                                else if($leave->leave_type == '6')
                                {
                                    $ltype = "Planned Leave";
                                }
                                else if($leave->leave_type == '7')
                                {
                                    $ltype = "Restricted Leave";
                                }
                                else if($leave->leave_type == '8')
                                {
                                    $ltype = "Day Off";
                                }

                                if($leave->half_day == '1')
                                {
                                    $halfDay = "First Half";
                                }
                                elseif($leave->half_day == '2')
                                {
                                    $halfDay = "Second Half";
                                }
                                else {
                                    $halfDay = "Full Day";
                                }

                                $employeeName = $leave->employee_name;
                                $dateFrom = $leave->date_from;
                                $dateTo = $leave->date_to;
                                $noOfDays = $leave->no_of_days;
                                $reliever = $leave->reliever_name;
                                ?>

                                <table style="border-spacing:0; padding: 5px" width="100%">
                                    <tbody bgcolor="#dddddd">
                                    <tr bgcolor="#dddddd">
                                        <td style="padding: 10px; margin-bottom: 20px; background-color: #dddddd" bgcolor="#dddddd">
                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Employee Name: </span>
                                                <?=$employeeName; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                                                <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                                                <?=$ltype; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Half Day: </span>
                                                <?=$halfDay; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>No. of days: </span>
                                                <?=$noOfDays; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                                                <?=$reliever ?>
                                            </p>
                                        </td>
                                    </tr>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--     For Dhaka -->
                    <div style="margin-bottom: 10px; border: 1px solid #000000">
                        <table style="border-spacing:0; padding: 5px" width="100%">
                            <tbody>
                            <tr>
                                <td align="center" class="inner heading-table" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                    <h2 style="font-family: Verdana,Geneva,sans-serif;">Total leave from Dhaka : <span style="color: YellowGreen;"><?=$totalLeavesFromDhkCount?></span></h2>
                                </td>
                            </tr>

                            <?php
                            foreach ($totalLeavesFromDhk as $leave)
                            {
                                if($leave->leave_type == '1')
                                {
                                    $ltype = "Sick Leave";
                                }
                                else if($leave->leave_type == '2')
                                {
                                    $ltype = "Casual Leave";
                                }
                                else if($leave->leave_type == '4')
                                {
                                    $ltype = "Earned Leave";
                                }
                                else if($leave->leave_type == '5')
                                {
                                    $ltype = "Unplanned Leave";
                                }
                                else if($leave->leave_type == '6')
                                {
                                    $ltype = "Planned Leave";
                                }
                                else if($leave->leave_type == '7')
                                {
                                    $ltype = "Restricted Leave";
                                }
                                else if($leave->leave_type == '8')
                                {
                                    $ltype = "Day Off";
                                }

                                if($leave->half_day == '1')
                                {
                                    $halfDay = "First Half";
                                }
                                elseif($leave->half_day == '2')
                                {
                                    $halfDay = "Second Half";
                                }
                                else {
                                    $halfDay = "Full Day";
                                }

                                $employeeName = $leave->employee_name;
                                $dateFrom = $leave->date_from;
                                $dateTo = $leave->date_to;
                                $noOfDays = $leave->no_of_days;
                                $reliever = $leave->reliever_name;
                                ?>

                                <table style="border-spacing:0; padding: 5px" width="100%">
                                    <tbody bgcolor="#dddddd">
                                    <tr bgcolor="#dddddd">
                                        <td style="padding: 10px; margin-bottom: 20px; background-color: #dddddd" bgcolor="#dddddd">
                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Employee Name: </span>
                                                <?=$employeeName; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                                                <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                                                <?=$ltype; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Half Day: </span>
                                                <?=$halfDay; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>No. of days: </span>
                                                <?=$noOfDays; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                                                <?=$reliever ?>
                                            </p>
                                        </td>
                                    </tr>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--  For Goa  -->
                    <div style="margin-bottom: 10px; border: 1px solid #000000">
                        <table style="border-spacing:0; padding: 5px" width="100%">
                            <tbody>
                            <tr>
                                <td align="center" class="inner heading-table" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                    <h2 style="font-family: Verdana,Geneva,sans-serif;">Total leave from Goa : <span style="color: YellowGreen;"><?=$totalLeavesFromGoaCount?></span></h2>
                                </td>
                            </tr>

                            <?php
                            foreach ($totalLeavesFromGoa as $leave)
                            {
                                if($leave->leave_type == '1')
                                {
                                    $ltype = "Sick Leave";
                                }
                                else if($leave->leave_type == '2')
                                {
                                    $ltype = "Casual Leave";
                                }
                                else if($leave->leave_type == '4')
                                {
                                    $ltype = "Earned Leave";
                                }
                                else if($leave->leave_type == '5')
                                {
                                    $ltype = "Unplanned Leave";
                                }
                                else if($leave->leave_type == '6')
                                {
                                    $ltype = "Planned Leave";
                                }
                                else if($leave->leave_type == '7')
                                {
                                    $ltype = "Restricted Leave";
                                }
                                else if($leave->leave_type == '8')
                                {
                                    $ltype = "Day Off";
                                }

                                if($leave->half_day == '1')
                                {
                                    $halfDay = "First Half";
                                }
                                elseif($leave->half_day == '2')
                                {
                                    $halfDay = "Second Half";
                                }
                                else {
                                    $halfDay = "Full Day";
                                }

                                $employeeName = $leave->employee_name;
                                $dateFrom = $leave->date_from;
                                $dateTo = $leave->date_to;
                                $noOfDays = $leave->no_of_days;
                                $reliever = $leave->reliever_name;
                                ?>

                                <table style="border-spacing:0; padding: 5px" width="100%">
                                    <tbody bgcolor="#dddddd">
                                    <tr bgcolor="#dddddd">
                                        <td style="padding: 10px; margin-bottom: 20px; background-color: #dddddd" bgcolor="#dddddd">
                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Employee Name: </span>
                                                <?=$employeeName; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                                                <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                                                <?=$ltype; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Half Day: </span>
                                                <?=$halfDay; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>No. of days: </span>
                                                <?=$noOfDays; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                                                <?=$reliever ?>
                                            </p>
                                        </td>
                                    </tr>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--  For NewYork  -->
                    <div style="margin-bottom: 10px; border: 1px solid #000000">
                        <table style="border-spacing:0; padding: 5px" width="100%">
                            <tbody>
                            <tr>
                                <td align="center" class="inner heading-table" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                    <h2 style="font-family: Verdana,Geneva,sans-serif;">Total leave from Newyork : <span style="color: YellowGreen;"><?=$totalLeavesFromNycCount?></span></h2>
                                </td>
                            </tr>

                            <?php
                            foreach ($totalLeavesFromNyc as $leave)
                            {
                                if($leave->leave_type == '1')
                                {
                                    $ltype = "Sick Leave";
                                }
                                else if($leave->leave_type == '2')
                                {
                                    $ltype = "Casual Leave";
                                }
                                else if($leave->leave_type == '4')
                                {
                                    $ltype = "Earned Leave";
                                }
                                else if($leave->leave_type == '5')
                                {
                                    $ltype = "Unplanned Leave";
                                }
                                else if($leave->leave_type == '6')
                                {
                                    $ltype = "Planned Leave";
                                }
                                else if($leave->leave_type == '7')
                                {
                                    $ltype = "Restricted Leave";
                                }
                                else if($leave->leave_type == '8')
                                {
                                    $ltype = "Day Off";
                                }

                                if($leave->half_day == '1')
                                {
                                    $halfDay = "First Half";
                                }
                                elseif($leave->half_day == '2')
                                {
                                    $halfDay = "Second Half";
                                }
                                else {
                                    $halfDay = "Full Day";
                                }

                                $employeeName = $leave->employee_name;
                                $dateFrom = $leave->date_from;
                                $dateTo = $leave->date_to;
                                $noOfDays = $leave->no_of_days;
                                $reliever = $leave->reliever_name;
                                ?>

                                <table style="border-spacing:0; padding: 5px" width="100%">
                                    <tbody bgcolor="#dddddd">
                                    <tr bgcolor="#dddddd">
                                        <td style="padding: 10px; margin-bottom: 20px; background-color: #dddddd" bgcolor="#dddddd">
                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Employee Name: </span>
                                                <?=$employeeName; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                                                <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                                                <?=$ltype; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Half Day: </span>
                                                <?=$halfDay; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>No. of days: </span>
                                                <?=$noOfDays; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                                                <?=$reliever ?>
                                            </p>
                                        </td>
                                    </tr>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--  For Ukraine  -->
                    <div style="margin-bottom: 10px; border: 1px solid #000000">
                        <table style="border-spacing:0; padding: 5px" width="100%">
                            <tbody>
                            <tr>
                                <td align="center" class="inner heading-table" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                    <h2 style="font-family: Verdana,Geneva,sans-serif;">Total leave from Ukraine : <span style="color: YellowGreen;"><?=$totalLeavesFromUkrCount?></span></h2>
                                </td>
                            </tr>

                            <?php
                            foreach ($totalLeavesFromUkr as $leave)
                            {
                                if($leave->leave_type == '1')
                                {
                                    $ltype = "Sick Leave";
                                }
                                else if($leave->leave_type == '2')
                                {
                                    $ltype = "Casual Leave";
                                }
                                else if($leave->leave_type == '4')
                                {
                                    $ltype = "Earned Leave";
                                }
                                else if($leave->leave_type == '5')
                                {
                                    $ltype = "Unplanned Leave";
                                }
                                else if($leave->leave_type == '6')
                                {
                                    $ltype = "Planned Leave";
                                }
                                else if($leave->leave_type == '7')
                                {
                                    $ltype = "Restricted Leave";
                                }
                                else if($leave->leave_type == '8')
                                {
                                    $ltype = "Day Off";
                                }

                                if($leave->half_day == '1')
                                {
                                    $halfDay = "First Half";
                                }
                                elseif($leave->half_day == '2')
                                {
                                    $halfDay = "Second Half";
                                }
                                else {
                                    $halfDay = "Full Day";
                                }

                                $employeeName = $leave->employee_name;
                                $dateFrom = $leave->date_from;
                                $dateTo = $leave->date_to;
                                $noOfDays = $leave->no_of_days;
                                $reliever = $leave->reliever_name;
                                ?>

                                <table style="border-spacing:0; padding: 5px" width="100%">
                                    <tbody bgcolor="#dddddd">
                                    <tr bgcolor="#dddddd">
                                        <td style="padding: 10px; margin-bottom: 20px; background-color: #dddddd" bgcolor="#dddddd">
                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Employee Name: </span>
                                                <?=$employeeName; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Date: </span>
                                                <?=date('D, jS M, Y', strtotime($dateFrom)); ?> to <?=date('D, jS M, Y', strtotime($dateTo)); ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Leave Type: </span>
                                                <?=$ltype; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Half Day: </span>
                                                <?=$halfDay; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>No. of days: </span>
                                                <?=$noOfDays; ?>
                                            </p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" class="inner" style="padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;" valign="middle">
                                            <p style="font-weight: bold; font-size: 16px; font-family: Verdana,Geneva,sans-serif;"> <span>Reliever: </span>
                                                <?=$reliever ?>
                                            </p>
                                        </td>
                                    </tr>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>

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


            <!-- Social Media -->
            <!-- <tr> -->
            <!-- <td align="center" style="padding-bottom:0;padding-right:0;padding-left:0;padding-top:0px;" valign="middle"> -->
            <!-- <span class="sg-image" data-imagelibrary="%7B%22width%22%3A%228%22%2C%22height%22%3A18%2C%22alt_text%22%3A%22Facebook%22%2C%22alignment%22%3A%22%22%2C%22border%22%3A0%2C%22src%22%3A%22https%3A//marketing-image-production.s3.amazonaws.com/uploads/0a1d076f825eb13bd17a878618a1f749835853a3a3cce49111ac7f18255f10173ecf06d2b5bd711d6207fbade2a3779328e63e26a3bfea5fe07bf7355823567d.png%22%2C%22link%22%3A%22%23%22%2C%22classes%22%3A%7B%22sg-image%22%3A1%7D%7D">
              <a href="https://www.facebook.com/sjinnovation/" target="_blank">
                <img alt="Facebook" height="18" src="https://marketing-image-production.s3.amazonaws.com/uploads/0a1d076f825eb13bd17a878618a1f749835853a3a3cce49111ac7f18255f10173ecf06d2b5bd711d6207fbade2a3779328e63e26a3bfea5fe07bf7355823567d.png" style="border-width: 0px; margin-right: 21px; margin-left: 21px; width: 8px; height: 18px;" width="8">
              </a>
            </span> -->
            <!--[if gte mso 9]>&nbsp;&nbsp;&nbsp;<![endif]-->
            <!-- <span class="sg-image" data-imagelibrary="%7B%22width%22%3A%2223%22%2C%22height%22%3A18%2C%22alt_text%22%3A%22Twitter%22%2C%22alignment%22%3A%22%22%2C%22border%22%3A0%2C%22src%22%3A%22https%3A//marketing-image-production.s3.amazonaws.com/uploads/6234335b200b187dda8644356bbf58d946eefadae92852cca49fea227cf169f44902dbf1698326466ef192bf122aa943d61bc5b092d06e6a940add1368d7fb71.png%22%2C%22link%22%3A%22%23%22%2C%22classes%22%3A%7B%22sg-image%22%3A1%7D%7D">
              <a href="https://twitter.com/sjinnovation?lang=en" target="_blank">
                <img alt="Twitter" height="18" src="https://marketing-image-production.s3.amazonaws.com/uploads/6234335b200b187dda8644356bbf58d946eefadae92852cca49fea227cf169f44902dbf1698326466ef192bf122aa943d61bc5b092d06e6a940add1368d7fb71.png" style="border-width: 0px; margin-right: 16px; margin-left: 16px; width: 23px; height: 18px;" width="23">
              </a>
            </span> -->
            <!--[if gte mso 9]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]-->
            <!-- <span class="sg-image" data-imagelibrary="%7B%22width%22%3A%2218%22%2C%22height%22%3A18%2C%22alt_text%22%3A%22Instagram%22%2C%22alignment%22%3A%22%22%2C%22border%22%3A0%2C%22src%22%3A%22https%3A//marketing-image-production.s3.amazonaws.com/uploads/650ae3aa9987d91a188878413209c1d8d9b15d7d78854f0c65af44cab64e6c847fd576f673ebef2b04e5a321dc4fed51160661f72724f1b8df8d20baff80c46a.png%22%2C%22link%22%3A%22%23%22%2C%22classes%22%3A%7B%22sg-image%22%3A1%7D%7D">
              <a href="https://www.instagram.com/sj_innovation/" target="_blank">
                <img alt="Instagram" height="18" src="https://marketing-image-production.s3.amazonaws.com/uploads/650ae3aa9987d91a188878413209c1d8d9b15d7d78854f0c65af44cab64e6c847fd576f673ebef2b04e5a321dc4fed51160661f72724f1b8df8d20baff80c46a.png" style="border-width: 0px; margin-right: 16px; margin-left: 16px; width: 18px; height: 18px;" width="18">
              </a>
            </span> -->
            <!-- </td> -->
            <!-- </tr> -->


            <!-- whitespace -->
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