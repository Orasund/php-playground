<? session_start();
if(!isset($_SESSION['user_admin'])) {
header("Location: index.php");
exit();
}
include '../dbc.php';
$page_limit = 15; 

if (!isset($_GET['page']) )
{ $start=0; } else
{ $start = ($_GET['page'] - 1) * $page_limit; }


$rs_all = mysql_query("select count(*) as total_all from users") or die(mysql_error());
$rs_active = mysql_query("select count(*) as total_active from users where approved='1'") or die(mysql_error());

$rs_pending = mysql_query("select * from users where approved='0'
						   limit $start,$page_limit
						   ") or die(mysql_error());
$rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");						   
list($total_pending) = mysql_fetch_row($rs_total_pending);

$rs_recent = mysql_query("select * from users where approved='1' order by date desc limit 25") or die(mysql_error());

list($all) = mysql_fetch_row($rs_all);
list($active) = mysql_fetch_row($rs_active);
$nos_pending = mysql_num_rows($rs_pending);

?>
<html>
<head>
<title>Administration Main Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="11%" valign="top"><p>Admin Main</p>
      <p><br>
        <a href="newuser.php">Create User</a><br>
        <a href="admin_ban.php">Ban/Unban </a><br>
        <a href="admin_logout.php">Logout</a> <br>
      </p></td>
    <td width="77%"><h2>Administration Page</h2>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>Total users: <? echo $all;?></td>
          <td>Active users: <? echo $active; ?></td>
          <td>Pending users: <? echo $nos_pending; ?></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <table width="80%" border="0" align="center" cellpadding="10" cellspacing="5" bgcolor="#e5ecf9">
        <tr>
          <td><form name="form1" method="post" action="admin_results.php">
              Search 
              <input name="q" type="text" id="q">
              <input type="submit" name="Submit" value="Submit">
              [Type email or name] </form></td>
        </tr>
      </table>
      <p><strong>*Note: </strong>Once the user is banner, he/she will never be 
        able to register new account with same email address.</p>
      <h3>Users Pending Approval</h3>
      <p>Approve -&gt; A notification email will be sent to user notifying activation.<br>
        Ban -&gt; No notification email will be sent to the user.</p>
      <p>Total Pending: <? echo $total_pending; ?></p>
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#e5ecf9"> 
          <td width="4%"><strong>ID</strong></td>
          <td> <strong>Date</strong></td>
          <td><strong>User Name</strong></td>
          <td width="29%"><strong>Email</strong></td>
          <td width="10%"><strong>Approved</strong></td>
          <td width="8%"> <strong>Banned</strong></td>
          <td width="19%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td width="12%">&nbsp;</td>
          <td width="18%">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <? while ($prows = mysql_fetch_array($rs_pending)) {?>
    <tr> 
          <td>#<? echo $prows['id']?></td>
          <td><? echo $prows['date']?></td>
          <td><? echo $prows['user_name']?></td>
          <td><? echo $prows['user_email']?></td>
          <td> <span id="papprove<? echo $prows['id']; ?>">
            <? if(!$prows['approved']) { echo "Pending"; } else {echo "yes"; }?>
			</span>
          </td>
          <td><span id="pban<? echo $prows['id']; ?>">
            <? if(!$prows['banned']) { echo "no"; } else {echo "yes"; }?>
			</span> 
          </td>
          <td>
		    <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<? echo $prows['id']; ?>" } ,function(data){ $("#papprove<? echo $prows['id']; ?>").html(data); });'>Approve</a> 
           | <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<? echo $prows['id']; ?>" } ,function(data){ $("#pban<? echo $prows['id']; ?>").html(data); });'>Ban</a> 
		   | <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<? echo $prows['id']; ?>" } ,function(data){ $("#pban<? echo $prows['id']; ?>").html(data); });'>Unban</a>
			</td>
        </tr>
        <? } ?>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	  <p>  <?php
	  // generate paging here
	  if ($total_pending > $page_limit)
	  {
	   $total_pages = ceil($total_pending/$page_limit);
	   echo "<h4><font color=\"#CC0000\">Pages: </font>";
	  $i = 0;
		while ($i < $total_pages) 
		{
				$page_no = $i+1;
				echo "<a href=\"admin_main.php?page=$page_no\">$page_no</a> ";
				$i++;
		}
	  echo "</h4>";
	  }?>
      </p>
      <p>
        <input name="doRefresh" type="button" id="doRefresh" value="Refresh All" onClick="location.reload();">
      </p>
      <h3>Recent Registrations</h3>
      <p>This shows to <strong>25 latest approved</strong> registrations and their 
        banned status.</p>
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#e5ecf9"> 
          <td width="4%"><strong>ID</strong></td>
          <td> <strong>Date</strong></td>
          <td><strong>User Name</strong></td>
          <td width="29%"><strong>Email</strong></td>
          <td width="10%"><strong>Approved</strong></td>
          <td width="8%"> <strong>Banned</strong></td>
          <td width="19%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td width="12%">&nbsp;</td>
          <td width="18%">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <? while ($rrows = mysql_fetch_array($rs_recent)) {?>
    <tr> 
          <td>#<? echo $rrows['id']?></td>
          <td><? echo $rrows['date']?></td>
          <td><? echo $rrows['user_name']?></td>
          <td><? echo $rrows['user_email']?></td>
          <td> <span id="approve<? echo $rrows['id']; ?>">
            <? if(!$rrows['approved']) { echo "Pending"; } else {echo "yes"; }?>
			</span>
          </td>
          <td><span id="ban<? echo $rrows['id']; ?>">
            <? if(!$rrows['banned']) { echo "no"; } else {echo "yes"; }?>
			</span> 
          </td>
          <td>
		    <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<? echo $rrows['id']; ?>" } ,function(data){ $("#approve<? echo $rrows['id']; ?>").html(data); });'>Approve</a> 
           | <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<? echo $rrows['id']; ?>" } ,function(data){ $("#ban<? echo $rrows['id']; ?>").html(data); });'>Ban</a> 
		   | <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<? echo $rrows['id']; ?>" } ,function(data){ $("#ban<? echo $rrows['id']; ?>").html(data); });'>Unban</a>
			</td>
        </tr>
        <? } ?>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="12%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
