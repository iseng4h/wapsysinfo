<?php
//Do not changes this header, change only the configuration
header("Content-type: text/vnd.wap.wml");
echo ("<?xml version=\"1.0\"?>");
echo ("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\""
. " \"http://www.wapforum.org/DTD/wml_1.1.xml\">");
//Do not changes this header, change only the configuration
?>

<?php
//===============Configuration===============

//use true if you install this services or false if not
$APACHECONF=true;      //Apache
$PROFTPCONF=true;      //Proftp
$MYSQLCONF=true;       //MySQL
$SSHCONF=true;         //SSH
$INETCONF=true;        //xinetd or inetd
$SYSLOGCONF=true;      //syslog

//use postfix, sendmail, exim, qmail or none for $MAILCONF
$MAILCONF=postfix;     //SMTP
$POP3CONF=false;       //pop3 daemon
$IMAPCONF=false;       //imap daemon

//Thats all =================================
?>


<wml> 
<card id="sysinfo" title="WAP-Sysinfo" ontimer="wapsysinfo.php">
<timer value="300"/>
<p>
<?php   
    $the_date = date("d M Y/H:i");
    print $the_date;
    echo "<br/>";
    $HOSTNAME = `hostname`;
    echo "host: <pre>$HOSTNAME</pre>";
    echo "<br/>==========<br/>";  
?>
Services:<br/>
<?php
//Apache check
  if ($APACHECONF==true) : 
    system( `if ps -ax | grep -v grep | grep apache ; then echo "up" > /tmp/httpd.sys ; else echo "down" > /tmp/httpd.sys ;fi`);
    $WEB = `cat /tmp/httpd.sys`;
    echo "- Apache : <pre>$WEB</pre>";
    echo "<br/>";
  endif;
  
//Proftpd check  
  if ($PROFTPCONF==true):
    system( `if ps -ax | grep -v grep | grep proftpd; then echo "up" > /tmp/proftpd.sys; else echo "down" > /tmp/proftpd.sys; fi`);
    $FTP = `cat /tmp/proftpd.sys`;
    echo "- ProFTP : <pre>$FTP</pre>";
    echo "<br/>";
  endif;
  
//Mysqld check
  if ($MYSQLCONF==true):
    system( `if ps -ax | grep -v grep | grep mysqld; then echo "up"> /tmp/mysqld.sys; else echo "down" > /tmp/mysqld.sys; fi;`);
    $SQL = `cat /tmp/mysqld.sys`;
    echo "- MySQL : <pre>$SQL</pre>";
    echo "<br/>";
  endif;
  
//Sshd check 
  if ($SSHCONF==true):
    system( `if ps -ax | grep -v grep | grep sshd; then echo "up"> /tmp/sshd.sys; else echo "down" > /tmp/sshd.sys; fi;`);
    $SSH = `cat /tmp/sshd.sys`;
    echo "- SSH : <pre>$SSH</pre>";
    echo "<br/>";
  endif;
  
//(X)inetd check
  if ($INETCONF==true):
    system( `if ps -ax | grep -v grep | grep inetd; then echo "up"> /tmp/inetd.sys; else echo "down" > /tmp/inetd.sys; fi;`);
    $INET = `cat /tmp/inetd.sys`;
    echo "- (x)inetd : <pre>$INET</pre>";
    echo "<br/>";
  endif;
  
//syslogd check
  if ($SYSLOGCONF==true):
    system( `if ps -ax | grep -v grep | grep syslogd; then echo "up"> /tmp/syslogd.sys; else echo "down" > /tmp/syslogd.sys; fi;`);
    $SYS = `cat /tmp/syslogd.sys`;
    echo "- syslogd : <pre>$SYS</pre>";
    echo "<br/>";
  endif;

//mail check
  if ( ($MAILCONF==sendmail) || ($MAILCONF==postfix) || ($MAILCONF==exim) || ($MAILCONF==qmail) ):
    system ( `if ps -ax | grep -v grep | grep $MAILCONF; then echo "up" > /tmp/mail.sys; else echo "down" > /tmp/mail.sys; fi;`);
    $MAIL = `cat /tmp/mail.sys`;
    echo "- Mail $MAILCONF : <pre>$MAIL</pre>";
    echo "<br/>";
  endif;

//pop3 check
  if ( $POP3CONF==true ):
    system ( `if ps -ax | grep -v grep | grep pop; then echo "up" > /tmp/pop3.sys; else echo "down" > /tmp/pop3.sys; fi;`);
    $POP3 = `cat /tmp/pop3.sys`;
    echo "- POP3 : <pre>$POP3</pre>";
    echo "<br/>";
  endif;

//imap check
  if ( $IMAPCONF==true ):
    system ( `if ps -ax | grep -v grep | grep imap; then echo "up" > /tmp/imap.sys; else echo "down" > /tmp/imap.sys; fi;`);
    $IMAP = `cat /tmp/imap.sys`;
    echo "- IMAP : <pre>$IMAP</pre>";
    echo "<br/>";
  endif;

//Uptime user load
  $UPTIME = `uptime`;
  echo "<br/>Status :<br/><pre>$UPTIME</pre>";
  echo "<br/>";

//Mem, Swap, and Disk usage
  $MEMTOTAL = `cat /proc/meminfo| grep MemTotal:| awk '{print $2}'`;
  $MEMFREE = `cat /proc/meminfo| grep MemFree:| awk '{print $2}'`;
  $SWAPTOTAL = `cat /proc/meminfo| grep SwapTotal:| awk '{print $2}'`;
  $SWAPFREE = `cat /proc/meminfo| grep SwapFree:| awk '{print $2}'`;
  $PART = `df -h | grep -v grep | grep dev | awk '{ print $1"<br/> "}' `;
  $DISK = `df -h | grep -v grep | grep G | awk '{ print $1"<br/> "}' `;
  echo "<br/>Mem [Total/Free]: <pre>$MEMTOTAL/ $MEMFREE</pre>";
  echo "<br/>Swap [Total/Free]: <pre>$SWAPTOTAL/ $SWAPFREE</pre>";
  echo "<br/>Disk Free :<br/><pre>$PART $DISK</pre>";
  echo "<br/>";
?>
==========<br/>
WAP-Sysinfo 0.1 by Dhoto
</p>
</card>
</wml>
		
