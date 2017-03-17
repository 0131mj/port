<?php
ini_set('magic_quotes_runtime', 0);
global $global_string_temp;
$global_string_temp = "_";

function wkfunc_file_find_from_title($title_parameter)
{
	$file_number_counter = 0;
	$file_name_return = "__NONEXISTANCE__";
	$temporal_file_pointer = 0;
	$temporal_title = "";
	$temporal_max = 0;
	$dir=opendir("./");
	while($file = readdir($dir)) {
	    if( strpos($file,"kct")==1 && (strpos($file,".txt") != false || strpos($file,".TXT") != false) && strcmp(str_replace(".bak","",$file),$file)==0 && strcmp(str_replace(".BAK","",$file),$file)==0 )
		{
		$file_number_counter++;
		$temporal_file_pointer = fopen( $file, "r" );
		$temporal_title = fgets($temporal_file_pointer);
		fclose( $temporal_file_pointer );

		$temporal_title = str_replace( "\r", "" , $temporal_title );
		$temporal_title = str_replace( "\n", "" , $temporal_title );
		$st = strpos( $file, "kct");
		$ed = strpos( $file, ".txt");
		$temporal_page_number = intval( substr( $file, $st+3, $ed-$st-3) );
		if( $temporal_max < $temporal_page_number ) $temporal_max = $temporal_page_number;

		if(strcmp($temporal_title,$title_parameter)==0 ) { $file_name_return = $file; closedir($dir); return $file_name_return;}
		}
	}
	closedir($dir);
	$temporal_max ++;
	if(intval($file_number_counter) < $temporal_max) $file_number_counter = $temporal_max;

	return $file_name_return.$file_number_counter;
}

function wkfunc_newest_file_find($time_parameter)
{
	$file_number_counter = 0;
	$file_name_return = "__NONEXISTANCE__";
	$temporal_file_pointer = 0;
	$temporal_title = "";
	$temporal_time_str = "";
	$temporal_time = "";
	$temporal_start = 0;
	$temporal_end = 0;
	$temporal_maximizer = 0;
	$temporal_return_value = "";

	$dir=opendir("./");
	while($file = readdir($dir)) {
	    if( (strpos($file,".txt") != false || strpos($file,".TXT") != false)  && strcmp(str_replace(".bak","",$file),$file)==0)
		{
		$file_number_counter++;
		$temporal_file_pointer = fopen( $file, "r" );
		$temporal_title = fgets($temporal_file_pointer);
		$temporal_time_str = fgets($temporal_file_pointer);
		$temporal_line1 =    fgets($temporal_file_pointer);
		$temporal_line2 =    fgets($temporal_file_pointer);
		fclose( $temporal_file_pointer );

		$temporal_title = str_replace( "\r", "" , $temporal_title );
		$temporal_title = str_replace( "\n", "" , $temporal_title );

		$temporal_start = strpos( $temporal_time_str, ": ")+2;
		$temporal_end = strpos( $temporal_time_str," /");
		$temporal_time = substr( $temporal_time_str , $temporal_start , $temporal_end - $temporal_start) + 0;

		if( $temporal_time > $temporal_maximizer && ($temporal_time < $time_parameter || $time_parameter==0 ) )
		{$temporal_maximizer=$temporal_time;
		$temporal_return_value=$temporal_time.":".$temporal_title."#CQSW?=".$temporal_time_str;
		$GLOBALS["global_string_temp"] = $temporal_line1."\n".$temporal_line2;
		$GLOBALS["global_string_temp"] = str_replace("<", "&lt;", $GLOBALS["global_string_temp"]);
		$GLOBALS["global_string_temp"] = str_replace(">", "&gt;", $GLOBALS["global_string_temp"]);}
	
		}
	}
	closedir($dir);
	return $temporal_return_value;
}


function wkfunc_first_title_file_find($title_parameter)
{
	$file_number_counter = 0;
	$file_name_return = "__NONEXISTANCE__";
	$temporal_file_pointer = 0;
	$temporal_title = "";
	$temporal_maximizer = "�R�R�R�R�R";
	$temporal_return_value = "";

	$title_parameter = str_replace( "\r", "" , $title_parameter );
	$title_parameter = str_replace( "\n", "" , $title_parameter );

	$dir=opendir("./");
	while($file = readdir($dir)) {
	    if(strpos($file,"kct")==1 && (strpos($file,".txt") != false || strpos($file,".TXT") != false)&& strpos($temporal_title,".bak")==false  && strcmp(str_replace(".bak","",$file),$file)==0 )
		{
		$file_number_counter++;
		$temporal_file_pointer = fopen( $file, "r" );
		$temporal_title = fgets($temporal_file_pointer);
		$temporal_time_str = fgets($temporal_file_pointer);
		fclose( $temporal_file_pointer );

		$temporal_title = str_replace( "\r", "" , $temporal_title );
		$temporal_title = str_replace( "\n", "" , $temporal_title );

		if( strcmp($temporal_title, $temporal_maximizer)<0 && ( strcmp($temporal_title,$title_parameter)>0 || strlen($title_parameter)<1 ) )
		{$temporal_maximizer=$temporal_title;
		$temporal_return_value=$temporal_title;}
		}
	}
	closedir($dir);
	return $temporal_return_value;
}


/* ---------------- Main routine ------------------ */

$fp=0;
$i=0;
$j=0;
$k=0;
$l=0;

$page_to_read="";
$page_to_edit="";
$filename_to_edit="";
$filename_to_read="";

$wk_design="";
$wk_title="";
$wk_date="";
$wk_contents="";
$wk_password="";
$wk_contents_ori="";
$wk_first_page_title="";

$main_temp="";
$main_temp2="";

$wk_head="";
$wk_tail="";
$wk_output="";

$position_of_contents=0;
$position_of_blit=0;
$position_of_headline=0;

$deco_headline_start="";
$deco_headline_end="";
$deco_blit_start="";

$deco_url="";


// What if nothing exists?

if(file_exists("wk_design.htm")==false){
$fp = fopen( "wk_design.htm", "wb" );
$temp_data = "";
$temp_data = $temp_data."<!--NOOEKAKI-->";
$temp_data = $temp_data."<title>��ŰŰ������</title>\n";
$temp_data = $temp_data."<H1>��ŰŰ������</H1>\n";
$temp_data = $temp_data."<H5>�����������Ͻ� �� �ۼ���</H5>\n";
$temp_data = $temp_data."<table width=750><tr><td>\n";
$temp_data = $temp_data."\n";
$temp_data = $temp_data."����������<BR><BR><H3>�����μ�����</H3><BR><BR><LI>������<BR>";
$temp_data = $temp_data."\n";
$temp_data = $temp_data."</td></tr></table>\n";
$temp_data = $temp_data."<a href='��������ġ�⸵ũ'>Edit</a>\n";
$temp_data = $temp_data."<a href='������Ʈ��������ũ'>Update</a>\n";
$temp_data = $temp_data."<a href='�����������ũ'>List</a>\n";
$temp_data = $temp_data."<a href='index.xml'>XML</a>\n";
fwrite( $fp, $temp_data );
fclose( $fp );}
if(file_exists("wkct0.txt")==false){
$fp = fopen( "wkct0.txt", "wb" );
$temp_data = "";
$temp_data = $temp_data."Start\n";
$temp_data = $temp_data."UNIX �ð� : 426426 / ��� �ð� 0426.04.26, 4:26 pm\n";
$temp_data = $temp_data."Wecome to WikiKiwi.\n";
$temp_data = $temp_data."If you want to know anything about Wikikiwi, then please visit [http://no-smok.net/nsmk/WikiKiwi] .";
$temp_data = $temp_data."";
fwrite( $fp, $temp_data );
fclose( $fp );}



// Read design file
$fp = fopen( "wk_design.htm", "r" );
$wk_design = fread( $fp, filesize( "wk_design.htm" ) );
fclose( $fp );

if(strpos($HTTP_GET_VARS["option"],"tatic")==1){ // if it's static creation, read "wk_design_static.htm"
if(file_exists("wk_design_static.htm")!=false){
$fp = fopen( "wk_design_static.htm", "r" );
$wk_design = fread( $fp, filesize( "wk_design_static.htm" ) );
fclose( $fp );
}}

// Design processing from contents
	// Catching Firstpage Title
	$fp = fopen( "wkct0.txt", "r" );
	$wk_first_page_title = fgets($fp);
	fclose( $fp );

	// Page title catching
if( strlen($page_to_read) < 1) $page_to_read = $HTTP_GET_VARS["pagetoread"];
if( strlen($page_to_read) < 1 || strcmp($page_to_read,"FIRSTPAGE")==0) $wk_title = $wk_first_page_title;
else if( strcmp($page_to_read,"TITLELIST")==0) $wk_title = "���� ���� ���";
else if( strcmp($page_to_read,"UPDATELIST")==0) $wk_title = "�ֱ� ������Ʈ ������";
else if( strcmp($page_to_read,"SRESULT")==0) {$wk_title = "�˻� ���";}
else if( strcmp($page_to_read,"SEARCH")==0) {$wk_title = "�˻�";}
else if( strcmp($page_to_read,"UPLOADED")==0) {$wk_title = "���� ���ε� �Ϸ�";}
else if( strcmp($page_to_read,"UPLOAD")==0) {$wk_title = "���� ���ε�";}
else $wk_title = $page_to_read;

	// Design automatic processing
	$wk_design = str_replace("��������������",$wk_first_page_title, $wk_design);
	$wk_design = str_replace("ó������������",$wk_first_page_title, $wk_design);
	$wk_design = str_replace("��ŰŰ������",$wk_title, $wk_design);
	$wk_design = str_replace("��������ġ�⸵ũ","index.php?pagetoedit=".$wk_title."&option=oekaki",$wk_design);
	$wk_design = str_replace("����ũ��������ũ","index.php?pagetoread=SRESULT&sphrase=[ ".$wk_title." ]",$wk_design);
	$wk_design = str_replace("��������ġ��","index.php?pagetoedit=".$wk_title."&option=oekaki",$wk_design);
	$wk_design = str_replace("�ؽ�Ʈ��ġ�⸵ũ","index.php?pagetoedit=".$wk_title,$wk_design);
	$wk_design = str_replace("Ʈ���麸���⸵ũ","index.php?pagetoread=".$wk_title."&option=trackback",$wk_design);	
	$wk_design = str_replace("����HTML������ũ","index.php?pagetoread=".$wk_title."&option=static",$wk_design);	
	$wk_design = str_replace("ó����������ũ","index.php?pagetoread=FIRSTPAGE",$wk_design);
	$wk_design = str_replace("�����������ũ","index.php?pagetoread=TITLELIST",$wk_design);
	$wk_design = str_replace("������Ʈ��������ũ","index.php?pagetoread=UPDATELIST",$wk_design);
	$wk_design = str_replace("���Ͼ��ε帵ũ","index.php?pagetoread=UPLOAD",$wk_design);
	$wk_design = str_replace("�˻���������ũ","index.php?pagetoread=SEARCH",$wk_design);
	$wk_design = str_replace("������������ũ","index.php?pagetoread=��ŰŰ��%20����",$wk_design);
	$wk_design = str_replace("���ο���������ũ","index.php?pagetoedit=�����Է�&option=oekaki", $wk_design);
	$wk_design = str_replace("��ŰŰ��RSS��ũ","index.xml",$wk_design);



	// Get position of each design element positioner
$position_of_contents = strpos($wk_design,"����������");
$position_of_headline = strpos($wk_design,"�����μ�����");
$position_of_blit = strpos($wk_design,"������");

	// Get the style of each design element
		// find the position of '<BR>' just in front of blit : $j
$j=0; // $j is the postion of the '<BR>' meaning starting of blit
for($i=0;$i<$position_of_blit;$i++){
	$k = strpos($wk_design,"<BR>",$i);
	if($k<$position_of_blit) $j=$k;
}
		// find the postion of '<BR>' just after contents : $k
$k = strpos($wk_design,"<BR>",$position_of_contents);

$deco_blit_start = substr( $wk_design, $j+4, $position_of_blit - $j - 4 );
$deco_headline_start = substr( $wk_design, $k+4, $position_of_headline - $k -4);
$deco_headline_end = substr( $wk_design, $position_of_headline + 14, $j - $position_of_headline - 14 );

	// Eliminate design elements from design file
$wk_head = substr( $wk_design, 0, $position_of_contents);
$wk_tail = substr( $wk_design, $position_of_blit+8);




// If there is command for editing
$page_to_edit = $HTTP_GET_VARS["pagetoedit"];
$j = $HTTP_GET_VARS["edittype"];

if( strlen($page_to_edit) >= 1 ) {

$filename_to_edit = wkfunc_file_find_from_title($page_to_edit);
$createnew = 0;
if(strpos($filename_to_edit,"_NONEXI")>0) {$createnew=1; $filename_to_edit="wkct".substr($filename_to_edit,16).".txt";}

if($createnew==0){
$fp = fopen( $filename_to_edit, "r" );
$wk_title = fgets($fp);
$wk_date = fgets($fp);
$wk_contents = fread( $fp, filesize( $filename_to_edit ) - strlen($wk_title) - strlen($wk_date));
fclose( $fp );
} else {
	$wk_title = $HTTP_GET_VARS["pagetiedit"];
	$wk_date = date("s");
	$wk_contents = "";
}
$wk_contents = str_replace("\r","",$wk_contents);


	// Password Processing
$i = substr($wk_contents,0,5);
if((strcmp($i,"��ȣ ")==0 || strcmp($i,"�ձ� ")==0  || strcmp($i,"��� ")==0)  && strcmp($j,"reply") != 0)
 {
	$i = strpos($wk_contents,"\n");
	$wk_password = substr($wk_contents,5,$i-5);
	if( strcmp($HTTP_GET_VARS["pwd"],$wk_password)!=0) { // If we don't have password then,
	echo "<script language='javascript'>\n";
	echo "var pwd;\n";
	echo "pwd = prompt('Password');\n";
	echo "location.replace('index.php?pagetoedit=$page_to_edit&pwd='+pwd);\n";
	// Send password to itself(reloading automatically occured)
	echo "</script>\n";
	exit();
	}
}

echo $wk_head;
echo "<form method=post action=index.php>\n";
if( ( strcmp($i,"�ձ� ")==0  && strcmp($j,"eply") == 1) || ( strcmp($i,"��� ")==0  && strcmp($j,"eply") == 1) || strcmp($j,"eply") == 1 )
{
echo  "�̸� <input name=name><BR>\n";
echo "���� <BR><TEXTAREA name=contents rows=30 cols=90>\n";
echo "</TEXTAREA><BR>\n";
}
else
{
echo  "���� <input name=title value=\"$page_to_edit\"><BR>\n";
echo "<TEXTAREA name=contents rows=30 cols=90>\n";
echo $wk_contents;
echo "</TEXTAREA><BR>\n";
}
echo "<input type=hidden name=pagetowrite value=\"$filename_to_edit\">\n";
echo "<input type=hidden name=itstitle value=\"$page_to_edit\">\n";
echo "<input type=hidden name=edittype value=\"$j\">\n";
echo "<input type=submit value=\"�Ϸ�\">\n";
echo "<BR>";
echo "<select name='filelinklist'>\n";


$dir=opendir("./");
while($file = readdir($dir)) {
        if(
        (strpos($file,"kct") && strpos($file,".txt")) ||
        (strpos($file,"kct") && strpos($file,".bak")) ||
        $file == "." ||
        $file == ".." ||
        (strpos($file,".php")) ||
        (strpos($file,".htm"))
        )
        if(strpos(":".$file,$filename_to_edit)==1 && strpos($file,".bak")>4)
		echo "<option>".$file."</option>\n"; else ;
        else echo "<option>".$file."</option>\n";
}
closedir($dir);

echo "</select>\n";
echo "<input type=button value='���� ��ũ ���̱�' OnClick='fileattach()'>\n";
echo "<input type=checkbox name=autolinkgen value=false>�ڵ���ũ����\n";
echo "</form>\n";
echo "<script language='javascript'>\n";
echo "function fileattach()\n";
echo "{\n";
echo "         filename = ' [LINK:' +document.forms[document.forms.length-1].filelinklist[ document.forms[document.forms.length-1].filelinklist.selectedIndex ].text + '] ';\n";
echo "         document.forms[document.forms.length-1].contents.value += filename;\n";
echo "}\n";
echo "</script>\n";

//oekaki
if(strpos($HTTP_GET_VARS["option"],"ekaki")==1 && strpos($wk_design,"!--NOOEKAKI--")<=0 )
 echo '
<div style="line-height: 0pt ; font-size : 20 ;">
<script language="javascript">
var width=40;
var formno=0;
var image_no_offset=-1;
formno = document.forms.length - 1;

var toggle=0;
var data = new Array(width*width);
function attach_standalone(){
	var offset = image_no_offset;
        var content = "<table cellspacing=0 cellpadding=0>\n";

        for(i=0;i<width;i++){
        content += "<tr height=5>";
                for(j=0;j<width;j++){
                content += ("<td bgcolor="+data[width*i+j+offset]+" width=5 height=5></td>");
                }
        content +="</tr>";
        }
        content +="\n</table>";
        document.forms[formno].contents.value=content;
}

function attach_wikikiwi(){
	var offset = image_no_offset;
        var content = "@JSoekaki_start@\n";

        for(i=0;i<width;i++){
        content += "{";
                for(j=0;j<width;j++){
                _src = document.images[width*i+j+offset].src;
                content += ( _src.charAt(_src.indexOf(".gif")-2) );
                }
        content +="}";
        }
        content +="\n@JSoekaki_end@";
        document.forms[formno].contents.value+=content;
}

function clicked(x,y)
{
	if(image_no_offset==-1){
		var L=document.images.length;
		for(i=0;i<L;i++){
		if(document.images[i].src.indexOf("bb.gif")>=0 && document.images[i].width==5)
			{image_no_offset = i;break;}
		}
	}
	var offset = image_no_offset;
        var I = width*y+x+offset;

        if(toggle==1) {
                document.images[I].src = colorsrc;
                data[I] = colordata;
        }
}

var ex=-1, ey=-1;

function togglepaint(x,y){
        if(toggle==0) {
		toggle=1;clicked(x,y);
		if(ex==x && ey==y) toggle=0;
	} else if(toggle==1) toggle=0;
	if(toggle==2) paintIt(x,y);
	ex=x;ey=y;
}

var colorcode = 0;
var colorsrc = "bb.gif";
var colordata = "#000000";

function pallette(){
 var offset = image_no_offset; colorcode++;
 colorsrc=numberToColor(colorcode);
 document.images[width*width+offset].src=(colorsrc);
 if(toggle!=2) toggle=0;
}

function numberToColor(N){
        if(N%8==0) {colordata="#000000";return "bb.gif";}
        if(N%8==1) {colordata="#FFFFFF";return "wb.gif";}
        if(N%8==2) {colordata="#FF0000";return "rb.gif";}
        if(N%8==3) {colordata="#FFFF00";return "yb.gif";}
        if(N%8==4) {colordata="#00FFFF";return "ob.gif";}
        if(N%8==5) {colordata="#0000FF";return "sb.gif";}
        if(N%8==6) {colordata="#00FF00";return "gb.gif";}
        if(N%8==7) {colordata="#5B5B5B";return "db.gif";}
}

function getSrcColor(x, y){
	var offset = image_no_offset;
        var I = width*y+x+offset;
        return( document.images[I].src );
}

function setSrcColor(x, y, c){
	var offset = image_no_offset;
        var I = width*y+x+offset;
        data[I] = colordata;
	document.images[I].src = colorsrc;
}

function paintIt(x, y){
	var color = getSrcColor(x,y);
	var ys = y, ye = y;
        for(i=y;i>=0;i--) {
		if(getSrcColor(x,i)!=color) break;
		setSrcColor(x,i);
		ys=i;
	}
        for(i=y+1;i<width;i++) {
		if(getSrcColor(x,i)!=color) break;
		setSrcColor(x,i);
		ye=i;
	}
	for(j=ys;j<=ye;j++){
	for(i=x-1;i>=0;i--){
		if(getSrcColor(i,j)!=color) break;
		setSrcColor(i,j);
	}
	for(i=x+1;i<width;i++){
		if(getSrcColor(i,j)!=color) break;
		setSrcColor(i,j);
	}}
}

</script>



<script language="javascript">
for(i=0;i<width;i++){
for(j=0;j<width;j++) {
        var I = width*i+j;
        data[I] = "#FFFFFF";
        src = "wb.gif";
        if(i==0 || j==0 || i==width-1 || j==width-1) src="bb.gif";
        document.write("<img src=\""+src+"\" onmouseover=\"clicked("+j+","+i+")\" width=5 height=5 margin=0 onclick=\"togglepaint("+j+","+i+")\">");
}
document.writeln("<BR>");
}

</script>
<BR>
<img src="bb.gif" width=32 height=32 onclick="pallette()" border=1>
<img src="icoatta.gif" onClick="attach_wikikiwi()"><img src="draw.gif" onClick="toggle=0"><img src="paint.gif" onClick="toggle=2">
</div>

<!-- if you want to use this in your zboard or other web application then add comment marking to the below -->
<!--
<HR>
<form>
<textarea name=contents cols=40 rows=20>




</textarea>
</form>
-->
';
//oekaki end

echo $wk_tail;

exit();
}





// If there is command for writing
$page_to_read = "";
$page_to_edit = "";
$page_to_edit = $HTTP_POST_VARS["pagetowrite"];
if(strlen($page_to_edit)<1) { // trackback acception processing
	$page_to_edit = $HTTP_GET_VARS["pagetowrite"];
	if(strpos($HTTP_POST_VARS["url"],"://")>0){
	$HTTP_POST_VARS["pagetowrite"] = $HTTP_GET_VARS["pagetowrite"];
	$HTTP_POST_VARS["edittype"] = "reply";
	$tb_title = $HTTP_POST_VARS["title"];
        $fp = fopen( $HTTP_POST_VARS["pagetowrite"], "r" );
        $wiki_title=fgets($fp);
	fclose($fp);
	$wiki_title = str_replace("\r","",$wiki_title);
	$wiki_title = str_replace("\n","",$wiki_title);
	$HTTP_POST_VARS["title"] = $wiki_title;

	$HTTP_POST_VARS["name"] = $HTTP_POST_VARS["blog_name"];
$HTTP_POST_VARS["excerpt"]=str_replace("'","",$HTTP_POST_VARS["excerpt"]);
$HTTP_POST_VARS["excerpt"]=str_replace("`","",$HTTP_POST_VARS["excerpt"]);
$HTTP_POST_VARS["excerpt"]=str_replace("=","",$HTTP_POST_VARS["excerpt"]);
$HTTP_POST_VARS["excerpt"]=str_replace("[","",$HTTP_POST_VARS["excerpt"]);
$HTTP_POST_VARS["exceprt"]=str_replace("]","",$HTTP_POST_VARS["excerpt"]);
	$HTTP_POST_VARS["contents"] = " ''' ".$tb_title."  [".$HTTP_POST_VARS["url"]."] ''' ".$HTTP_POST_VARS["excerpt"];
	}
}

if( strlen($page_to_edit) >= 1 ) {

if(strcmp($HTTP_POST_VARS["edittype"],"eply")==1)
{
	$fp = fopen( $HTTP_POST_VARS["pagetowrite"], "r" );
	$wk_title = fgets($fp);
	$wk_date = fgets($fp);
	$wk_contents_ori = fread( $fp, filesize( $HTTP_POST_VARS["pagetowrite"] ) - strlen($wk_title) - strlen($wk_date));
	$wk_contents_ori = str_replace("\r","",$wk_contents_ori);
	fclose( $fp );

	// Password processing
	$i = substr($wk_contents_ori,0,5);
	if( strcmp($i,"��ȣ ")==0 || strcmp($i,"�ձ� ")==0  || strcmp($i,"��� ")==0 ) {
	$k = strpos($wk_contents_ori,"\n");
	$j = substr($wk_contents_ori,0,$k); // $j is the first line of the file
	$i = substr($wk_contents_ori,0,5); // $i is the type of protection
	$wk_contents_ori = substr($wk_contents_ori,$k+1); // $wk_contents_ori is pure contents
	}
}

	if(strlen($HTTP_POST_VARS["title"])<1) $wk_title = $HTTP_POST_VARS["itstitle"]; else $wk_title = $HTTP_POST_VARS["title"];
	$wk_contents = $HTTP_POST_VARS["contents"];
        if( strlen($HTTP_POST_VARS["autolinkgen"]) > 0 ){ // Autolinkgeneration
            $wk_date ="";
            $main_temp2 = "";
            $i = 0;

            for($l=0;$l<300;$l++){
            	$main_temp = wkfunc_first_title_file_find($main_temp2);
             	if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
              	if(strcmp($main_temp,"����")!=0 && strcmp($main_temp,$wk_title)!=0) {
                 $wk_contents = str_replace( " [ ".$main_temp." ] ", $main_temp, $wk_contents);
                 $wk_contents = str_replace( $main_temp, " [ ".$main_temp." ] ",$wk_contents);
                 }
               	 else $l--;
                $main_temp2 = $main_temp;
	        }

        }

	// Magic quote anti-bug
	$wk_contents = str_replace("\\'","'",$wk_contents);
	$wk_contents = str_replace("\\\"","\"",$wk_contents);
	$wk_contents = str_replace("\\\\","\\",$wk_contents);

	
	// Backup
	if(file_exists($HTTP_POST_VARS["pagetowrite"])!=false){
		copy($HTTP_POST_VARS["pagetowrite"], $HTTP_POST_VARS["pagetowrite"].date("U").".bak");
	}

	// Automatic trackback processing
	$tb_url = "";
             	if( strpos( $wk_contents,   "tt/rserver.php?mode=tb&sl=") > 1 ) { // Tatertools trackback
		$ii = strpos ($wk_contents, "tt/rserver.php?mode=tb&sl=");

		$tmp_hd =  substr ($wk_contents, 0, $ii);
		$ii_http = strrpos($tmp_hd,     "[http://");
		$ie_http = strpos ($wk_contents, "]", $ii );
		$tb_url  = substr ($wk_contents, $ii_http+1, $ie_http-$ii_http-1);
		
		echo $tb_url;
		$wk_contents =  str_replace("tt/rserver.php?mode=tb&sl=", "tt/index.php?pl=", $wk_contents);
		}

             	if( strpos( $wk_contents,   "/blog/rserver.php?mode=tb&sl=") > 1 ) { // Tatertools trackback2
		$ii = strpos ($wk_contents, "/blog/rserver.php?mode=tb&sl=");

		$tmp_hd =  substr ($wk_contents, 0, $ii);
		$ii_http = strrpos($tmp_hd,     "[http://");
		$ie_http = strpos ($wk_contents, "]", $ii );
		$tb_url  = substr ($wk_contents, $ii_http+1, $ie_http-$ii_http-1);
		
		echo $tb_url;
		$wk_contents =  str_replace("/blog/rserver.php?mode=tb&sl=", "/blog/index.php?pl=", $wk_contents);
		}

             	if( strpos( $wk_contents,   ".egloos.com/tb/") > 1 ) { // Egloos trackback
		$ii = strpos ($wk_contents, ".egloos.com/tb/");

		$tmp_hd =  substr ($wk_contents, 0, $ii);
		$ii_http = strrpos($tmp_hd,     "[http://");
		$ie_http = strpos ($wk_contents, "]", $ii );
		$tb_url  = substr ($wk_contents, $ii_http+1, $ie_http-$ii_http-1);
		
		echo $tb_url;
		$wk_contents =  str_replace(".egloos.com/tb/", ".egloos.com/", $wk_contents);
		}

             	if( strpos( $wk_contents,   "www.blogin.com/tb/?id=") > 1 ) { // Blogin trackback
		$ii = strpos ($wk_contents, "www.blogin.com/tb/?id=");

		$tmp_hd =  substr ($wk_contents, 0, $ii);
		$ii_http = strrpos($tmp_hd,     "[http://");
		$ie_http = strpos ($wk_contents, "]", $ii );
		$tb_url  = substr ($wk_contents, $ii_http+1, $ie_http-$ii_http-1);
		
		echo $tb_url;
		$wk_contents =  str_replace("www.blogin.com/tb/?id=", "www.blogin.com/blog/main.php?datX=", $wk_contents);
		}


	// Actual wrting
        chmod( $HTTP_POST_VARS["pagetowrite"], 0777 );
	$fp = fopen( $HTTP_POST_VARS["pagetowrite"], "wb");
	fwrite( $fp, $wk_title."\n");
	fwrite( $fp, "UNIX �ð� : ".date("U")." / ��� �ð� ".date("Y.m.d, g:i a")."\n" );

	if((strcmp($i,"�ձ� ")==0  || strcmp($i,"��� ")==0 || 1==1) &&  strcmp($HTTP_POST_VARS["edittype"],"eply")==1) {
	// ��� �ޱ⳪ �߰��̸�
		if(strcmp($i,"�ձ� ")==0)
			{
			$j=$j."\n";
			fwrite( $fp, $j, strlen($j) );
			$wk_contents=$wk_contents."\n - '' ".$HTTP_POST_VARS["name"]." ".date("Y.m.d, g:i a")." '' ";
			$wk_contents=$wk_contents."\n----\n";
			fwrite( $fp, $wk_contents, strlen($wk_contents) );
			fwrite( $fp, $wk_contents_ori, strlen($wk_contents_ori) );
			}
		else
		//if(strcmp($i,"��� ")==0)
			{
			$j=$j;
			fwrite( $fp, $j, strlen($j) );
			if(strlen($j)>2) fwrite($fp,"\n");
			fwrite( $fp, $wk_contents_ori, strlen($wk_contents_ori) );
			$wk_contents="\n----\n".$wk_contents;
			$wk_contents=$wk_contents."\n - '' ".$HTTP_POST_VARS["name"]." ".date("Y.m.d, g:i a")." '' ";
			fwrite( $fp, $wk_contents, strlen($wk_contents) );
			}
	}
	else	fwrite( $fp, $wk_contents, strlen($wk_contents) );
	fclose($fp);

// RSS Feeding
// for blog RSS

$main_temp = wkfunc_newest_file_find(0);
$time_i = strpos($main_temp, "UNIX" );
$time_j = strpos($main_temp, " : ", $time_i)+3;
$time_k = strpos($main_temp, " ", $time_j);
$css_newest_time_stamp = 0 + (substr($main_temp, $time_j, $time_k-$time_j));
$css_newest_time = date("D, d M Y H:i:s O", $css_newest_time_stamp);
$css_URL_title_URI = $_SERVER['REQUEST_URI'];
$css_URL_title_hostname = $GLOBALS['HTTP_HOST'];
$css_URL_title = $css_URL_title_hostname . substr($css_URL_title_URI, 0, strpos($css_URL_title_URI,"index.php"));
$wk_date ="";
$wk_contents = "<?xml version=\"1.0\" encoding=\"euc-kr\"?>\n";
$wk_contents = $wk_contents."<rss version=\"2.0\"><channel><title>".$wk_first_page_title."</title>\n";
$wk_contents = $wk_contents."<link>http://".$css_URL_title."</link>\n";
$wk_contents = $wk_contents."<description>RSS generated from WikiKiwi</description>\n";
$wk_contents = $wk_contents."<language>ko</language>\n";
$wk_contents = $wk_contents."<pubDate>$css_newest_time</pubDate>\n";

$main_temp2 = "";
$i = 0;

for($l=0;$l<5;$l++){
        $main_temp = wkfunc_newest_file_find($i);
        if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
        $j = strpos($main_temp,":");
        $k = strpos($main_temp,"#CQSW?=");
        $time_i = strpos($main_temp, "UNIX");
        $time_j = strpos($main_temp, " : ", $time_i)+3;
        $time_k = strpos($main_temp, " ", $time_j);
        $css_time_stamp = 0 + (substr($main_temp, $time_j, $time_k-$time_j));
        $css_time = date("D, d M Y H:i:s O", $css_time_stamp);
        if(strcmp($main_temp,"����")!=0)
        {
                $wk_contents = $wk_contents."<item>";
                $wk_contents = $wk_contents."<title>".substr($main_temp,$j+1,$k-$j-1)."</title>\n";
                $wk_contents = $wk_contents."<link>http://".$css_URL_title."index.php?pagetoread=".substr($main_temp,$j+1, $k-$j-1)."</link>\n";
                $wk_contents = $wk_contents."<description>".$GLOBALS["global_string_temp"]."</description>\n";
                $wk_contents = $wk_contents."<category>none</category>\n";
                $wk_contents = $wk_contents."<authour>WikiKiwi</authour>\n";
                $wk_contents = $wk_contents."<pubDate>".$css_time."</pubDate></item>\n";
        }
        else $l--;
        $i  = 0+substr($main_temp,0,$j);
        $main_temp2 = $main_temp;
        }

$wk_contents = $wk_contents."</channel></rss>\n";
$fp = fopen( "index.xml", "wb");
fwrite( $fp, $wk_contents);
fclose($fp);
// end of RSS feeding


// Response to http
	$tb_url = urlencode( $tb_url );
	$page_to_read = $wk_title;
	if(strpos($HTTP_POST_VARS["url"],"://")>0) {
	echo('<?xml version="1.0" encoding="iso-8859-1" ?><response><error>0</error></response>');
	} else
	{
	if(strlen($tb_url)>3) 
		echo("<script language='javascript'>location.replace('index.php?pagetoread=$wk_title&option=trackback&target=".$tb_url."');\n</script>");
		else
		echo("<script language='javascript'>location.replace('index.php?pagetoread=$wk_title');\n</script>");
	}
	exit();
}







// If there in NOT any command then "read page 0"

if( strlen($page_to_read) < 1) $page_to_read = $HTTP_GET_VARS["pagetoread"];
if( strlen($page_to_read) < 1) $page_to_read = $HTTP_POST_VARS["pagetoread"];
	// If it's not function page
if( strlen($page_to_read) < 1 || strcmp($page_to_read,"FIRSTPAGE")==0) { $filename_to_read="wkct0.txt"; }
else if( strcmp($page_to_read,"TITLELIST")==0) {$wk_title = "���� ���� ���";}
else if( strcmp($page_to_read,"SRESULT")==0) {$wk_title = "�˻� ���";}
else if( strcmp($page_to_read,"SEARCH")==0) {$wk_title = "�˻�";}
else if( strcmp($page_to_read,"UPDATELIST")==0) {$wk_title = "�ֱ� ������Ʈ ������";}
else if( strcmp($page_to_read,"UPLOADED")==0) {$wk_title = "���� ���ε� �Ϸ�";}
else if( strcmp($page_to_read,"UPLOAD")==0) {$wk_title = "���� ���ε�";}

else	// If not
{
	$filename_to_read = wkfunc_file_find_from_title($page_to_read);

	if(strpos($filename_to_read,"_NONEXISTANCE__")!=false)
	{ // no existance then create new file
echo "<script language='javascript'>location.replace('index.php?pagetoedit=".$page_to_read."&option=oekaki');</script>\n";

echo $wk_head;
echo "<form method=post action=index.php>\n";
echo "<TEXTAREA name=contents rows=30 cols=90>\n";
echo "</TEXTAREA><BR>\n";
$filename_to_edit = "wkct".substr($filename_to_read,16).".txt";
echo "<input type=hidden name=pagetowrite value=\"$filename_to_edit\">\n";
echo "<input type=hidden name=itstitle value=\"$page_to_read\">\n";
echo "<input type=submit value=\"�Ϸ�\">\n";
echo "<BR><input type=checkbox name=autolinkgen value=false>�ڵ���ũ����\n";
echo "</form>";
echo $wk_tail;

exit();
	}
}

// Read page contents
// If it's special function page
if(strcmp($wk_title,"���� ���� ���")==0) {
$wk_date ="";
$wk_contents = "\n";
$main_temp2 = "";
$i = 0;

for($l=0;$l<300;$l++){
	$main_temp = wkfunc_first_title_file_find($main_temp2);
	if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
	if(strcmp($main_temp,"����")!=0) {$wk_contents = $wk_contents." *  [ ".$main_temp." ]  \n";}
	 else $l--;
	$main_temp2 = $main_temp;
	}

}



else if(strcmp($wk_title,"�˻� ���")==0) {
$wk_date ="";
$wk_contents = "\n";
$main_temp2 = "";
$main_title_temp = "";
$main_contents_temp = "";
$diff_temp = 0;
$i = 0;
$sphrase = $HTTP_GET_VARS["sphrase"];

$wk_contents = $wk_contents."�˻���: `` ".$sphrase." ''\n\n";

// Title Search
for($l=0;$l<500;$l++){
	$main_temp = wkfunc_first_title_file_find($main_temp2);
	if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
	if(strcmp($main_temp,"����")!=0){
		if ( strlen( $main_temp ) != strlen(str_replace($sphrase, "",$main_temp) )  )
		{	$wk_contents = $wk_contents." *  [ ".$main_temp." ]  \n";}
                } else $l--;
	$main_temp2 = $main_temp;
        }
// Contents Search
$wk_date ="";
$wk_contents = $wk_contents."\n";
$main_temp2 = "";
$main_title_temp = "";
$main_contents_temp = "";
$diff_temp = 0;
$i = 0;
for($l=0;$l<350;$l++){
	$main_temp = wkfunc_first_title_file_find($main_temp2);
	if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
	if(strcmp($main_temp,"����")!=0)
	{

               $filename_to_search = wkfunc_file_find_from_title($main_temp);
               $fp = fopen( $filename_to_search, "r" );
               $srcwk_title = fgets($fp);
               $srcwk_date = fgets($fp);
               $srcwk_contents = fread( $fp, filesize( $filename_to_search ) - strlen($srcwk_title) - strlen($srcwk_date));
               fclose( $fp );
               $srcwk_contents = " ".str_replace("\r","",$srcwk_contents);
               $srcwk_contents = str_replace("\n","",$srcwk_contents);
               $src_pos = strpos($srcwk_contents,$sphrase);
               if( $src_pos ) {
                  $wk_contents = $wk_contents." *  [ ".$main_temp." ]  \n at ".$src_pos."byte. \n\n";
                }
	} else $l--;
	$main_temp2 = $main_temp;
	}


}

else if(strcmp($wk_title,"�˻�")==0) {
$wk_contents = $wk_contents.'<form action="index.php" method="GET">';
$wk_contents = $wk_contents.'<input name="pagetoread" type="hidden" value="SRESULT">';
$wk_contents = $wk_contents.'<input name="sphrase" type="text">';
$wk_contents = $wk_contents.'<input type="submit" value="Search">';
$wk_contents = $wk_contents.'</form>';
}


else if(strcmp($wk_title,"���� ���ε�")==0) {
$wk_contents = $wk_contents.'<form enctype="multipart/form-data" action="index.php" method="POST">';
$wk_contents = $wk_contents.'<input name="pagetoread" type="hidden" value="UPLOADED">';
$wk_contents = $wk_contents.'<input name="userfile" type="file">';
$wk_contents = $wk_contents.'<input type="submit" value="upload">';
$wk_contents = $wk_contents.'</form>';
}

else if(strcmp($wk_title,"���� ���ε� �Ϸ�")==0) {
	$uploaddir = './';
	$uploadfile = $uploaddir. $_FILES['userfile']['name'];

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$wk_contents = $wk_contents."������ �����ϰ�, ���������� ���ε� �Ǿ����ϴ�.";
		$wk_contents = $wk_contents."�߰� ����� �����Դϴ�:\n";
                echo("<!--");print_r($_FILES);echo("-->");
	} else {
		$wk_contents = $wk_contents."���� ���ε� ������ ���ɼ��� �ֽ��ϴ�! ����� �����Դϴ�:\n";
                echo("<!--");print_r($_FILES);echo("-->");
	}

	$wk_contents = $wk_contents."<BR>\n * <a href='javascript:history.go(-2)'>���� ��������</a>";
}

//  Update List
else if(strcmp($wk_title,"�ֱ� ������Ʈ ������")==0) {
$wk_date ="";
$wk_contents = "\n";
$main_temp2 = "";
$i = 0;

for($l=0;$l<20;$l++){
	$main_temp = wkfunc_newest_file_find($i);
	if(strcmp($main_temp,$main_temp2)==0 || strlen($main_temp)<2 ) break;
	$j = strpos($main_temp,":");
	$k = strpos($main_temp,"#CQSW?=");
	if(strcmp($main_temp,"����")!=0)

         $wk_contents = $wk_contents." &nbsp; [LINK:moindiff.gif] [ ".substr($main_temp,$j+1,$k-$j-1)." ]  &nbsp;&nbsp; ".substr($main_temp,$k+7);
        else $l--;
	$i  = 0+substr($main_temp,0,$j);
	$main_temp2 = $main_temp;
	}
}

// If it's not
else {
$fp = fopen( $filename_to_read, "r" );
$wk_title = fgets($fp);
$wk_date = fgets($fp);
$wk_contents = fread( $fp, filesize( $filename_to_read ) - strlen($wk_title) - strlen($wk_date));
$wk_contents = str_replace("\r","",$wk_contents);
fclose( $fp );
}

// Password processing
$i = substr($wk_contents,0,5);
if( strcmp($i,"��ȣ ")==0 || strcmp($i,"�ձ� ")==0  || strcmp($i,"��� ")==0 ) {
	$i = strpos($wk_contents,"\n");
	$wk_contents = substr($wk_contents,$i+1);
}

	// Contents Designize
		// inclusion
if( strpos($wk_contents,"[IncludeUpdate") != false )
{
        $ii  = strpos($wk_contents,"[IncludeUpdate");
        $ii += 15;
        $ij  = strpos($wk_contents,"]", $ii);
        $include_timestamp= substr($wk_design, $ii, $ij-$ii);

        $main_temp = wkfunc_newest_file_find($include_timestamp);
        $ij = strpos($main_temp,":");
        $ik = strpos($main_temp,"#CQSW?=");
        $include_title = substr($main_temp,$ij+1,$ik-$ij-1);
        $include_time = substr($main_temp,$ik+7);
        $include_timestamp  = 0+substr($main_temp,0,$ij);

        $inc_filename_to_read = wkfunc_file_find_from_title($include_title);
$fp = fopen( $inc_filename_to_read, "r" );
$inc_wk_title = fgets($fp); 
$inc_wk_title = str_replace("\r","",$inc_wk_title);
$inc_wk_title = str_replace("\n","",$inc_wk_title);
$inc_wk_date = fgets($fp);
$inc_wk_firstline = " ".fgets($fp);
if(strpos($inc_wk_firstline,"�ձ� ")==1 || strpos($inc_wk_firstline,"��� ")==1)
	  $inc_wk_firstline=""; else $inc_wk_firstline = $inc_wk_firstline."\n";
$inc_wk_contents = $inc_wk_firstline . fread( $fp, filesize( $inc_filename_to_read ) - strlen($inc_wk_title) - strlen($inc_wk_date));
$inc_wk_contents = str_replace("\r","",$inc_wk_contents);
fclose( $fp );
        $inc_wk_contents = str_replace("[IncludeUpdate]","",$inc_wk_contents);

        $inclusion = "\n=== [ ".$inc_wk_title." ]  ===\n posted at ".$inc_wk_date."\n".$inc_wk_contents;
        $wk_contents = str_replace("[[IncludeUpdate".$time."]]",$inclusion, $wk_contents);
	$wk_title = $inc_wk_title;
	$filename_to_read = $inc_filename_to_read;
	$wk_date = $inc_wk_date;
}

		// non-decoratable processing
	$k=strpos($wk_contents,"\n{{{\n");
	$nondeco = "";
	if($k != false)
	{
		$l=strpos($wk_contents,"\n}}}\n");
		$nondeco =  substr($wk_contents,$k+5, $l-$k-5);
		$wk_contents = substr($wk_contents,0,$k)."--==NONDECO==--".substr($wk_contents,$l+5);
        }

		// Processing contents
if(strcmp($wk_title,"���� ���ε�")!=0 && strcmp($wk_title,"���� ���ε� �Ϸ�")!=0 && strcmp($wk_title,"�˻�")!=0) {
$wk_contents = str_replace("<","&lt;",$wk_contents);
$wk_contents = str_replace(">","&gt;",$wk_contents);
$wk_contents = str_replace("\n","<BR>\n",$wk_contents);
}

if(strpos($HTTP_GET_VARS["option"], "rackback")==1){ // processing trackback
$css_URL_title_URI = $_SERVER['REQUEST_URI'];
$css_URL_title_hostname = $GLOBALS['HTTP_HOST'];
$css_URL_title = $css_URL_title_hostname . substr($css_URL_title_URI, 0, strpos(
$css_URL_title_URI,"index.php"));

echo $wk_head;
echo '<form name=trackback method=post action="http://__">';
echo 'Ʈ���� ���� �ּ� <input name=actiontarget type=text size=60 value="'.$HTTP_GET_VARS["target"].'"><BR>';
echo '���� <input name=title type=text value="'.$wk_title.'">';
echo '<input name=blog_name type=hidden value="'.$wk_first_page_title.'"><br>';
echo '������ <textarea name=excerpt>'.substr($wk_contents,0,100).'</textarea><BR>';
echo '<input name=url type=hidden value="http://'.$css_URL_title."index.php?pagetoread=".$page_to_read.'">';
echo '<input name=go value="������" type=button onclick="gotrackback()">';
echo '</form>';
echo '<script language="javascript">';
echo 'function gotrackback(){';
echo 'document.trackback.action=document.trackback.actiontarget.value;';
echo 'document.trackback.submit();';
echo '}';
echo '</script>';
echo $wk_tail;
exit(0);
}

		// merging
$wk_design = $wk_head.$wk_contents.$wk_tail;
                        // New line processing
			// Special Date processing
$wk_design = str_replace("�����������Ͻ�",$wk_date, $wk_design);
			// Very Special Thing - costomizable
$wk_design = str_replace("''''''","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$wk_design);
                                        // For no-smok style
$wk_design = str_replace("\n==== ",$deco_headline_start." ", $wk_design);
$wk_design = str_replace(" ====<BR>",$deco_headline_end." ", $wk_design);
$wk_design = str_replace("\n=== ",$deco_headline_start." ", $wk_design);
$wk_design = str_replace(" ===<BR>",$deco_headline_end, $wk_design);
$wk_design = str_replace("\n== ",$deco_headline_start." ", $wk_design);
$wk_design = str_replace(" ==<BR>",$deco_headline_end, $wk_design);
$wk_design = str_replace(" {{|","[[[---Y<BR>", $wk_design);
$wk_design = str_replace("\n{{|","[[[---Y<BR>", $wk_design);
$wk_design = str_replace("|}}<BR>","Y---]]]<BR>", $wk_design);
$wk_design = str_replace("|}} ","Y---]]]<BR>", $wk_design);

                                        // Original Wikikiwi
$wk_design = str_replace("\n * ",$deco_blit_start." ",$wk_design);
$wk_design = str_replace("\n  * ",$deco_blit_start." ",$wk_design);
$wk_design = str_replace("[[[ ",$deco_headline_start." ", $wk_design);
$wk_design = str_replace(" ]]]"," ".$deco_headline_end, $wk_design);
$wk_design = str_replace("[[[---Y<BR>","<table style='background-color: #EEEEC0;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #FFFFE0;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #EEEEC0;text-align:left;padding: 5px;margin: 0px 10px;'>",$wk_design);
$wk_design = str_replace("Y---]]]<BR>","</td></tr></table>",$wk_design);
$wk_design = str_replace("[[[---G<BR>","<table style='background-color: #CCFFCC;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #CCFFCC;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #CCFFCC;text-align:left;padding: 5px;margin: 0px 10px;'>",$wk_design);
$wk_design = str_replace("G---]]]<BR>","</td></tr></table>",$wk_design);
$wk_design = str_replace("[[[---B<BR>","<table style='background-color: #CCFFFF;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #CCFFFF;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #CCFFFF;text-align:left;padding: 5px;margin: 0px 10px;'>",$wk_design);
$wk_design = str_replace("B---]]]<BR>","</td></tr></table>",$wk_design);
$wk_design = str_replace("[[[---F<BR>","<table style='background-color: #FFCCCC;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #EEF2CB;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #FFCCCC;text-align:left;padding: 5px;margin: 0px 10px;'>",$wk_design);
$wk_design = str_replace("F---]]]<BR>","</td></tr></table>",$wk_design);
$wk_design = str_replace("[[[---<BR>","<table style='background-color: #EEF2CB;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #EEF2CB;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #EEF2CB;text-align:left;padding: 5px;margin: 0px 10px;'>",$wk_design);
$wk_design = str_replace("---]]]<BR>","</td></tr></table>",$wk_design);



                                        // Macro
		// replay link macro
$wk_design = str_replace("���۴ޱ⸵ũ","index.php?pagetoedit=".$wk_title."&edittype=reply",$wk_design);

		// last updated link macro
if( strpos($wk_design,"[LastLink]") != false )
{
        $ii = strpos($wk_date,":")+1;
        $ie = strpos($wk_date," /");
        $include_timestamp=substr($wk_date, $ii, $ie-$ii);
        $main_temp = wkfunc_newest_file_find($include_timestamp);
        $ij = strpos($main_temp,":");
        $ik = strpos($main_temp,"#CQSW?=");
        $include_title = substr($main_temp,$ij+1,$ik-$ij-1);
        $include_timestamp  = 0+substr($main_temp,0,$ij);

        $inclusion = "<a href='index.php?pagetoread=".($include_title)."'>".$include_title."</a>";
        $wk_design = str_replace("[[LastLink]]", $inclusion, $wk_design);
}

$css_URL_title_URI = $_SERVER['REQUEST_URI'];
$css_URL_title_hostname = $GLOBALS['HTTP_HOST'];
$css_URL_title = $css_URL_title_hostname . substr($css_URL_title_URI, 0, strpos($css_URL_title_URI,"index.php"));
$wk_design = str_replace("Ʈ�����ּ�ǥ��", "http://".$css_URL_title."index.php?pagetowrite=".$filename_to_read, $wk_design);

if( strpos($wk_design,"[TableOfContents]") != false )
 {
        $j = strlen($wk_design);
        $c = 1;
        $tt = "";

        for($i=0;$i<$j;$i++){
           	$st=strpos($wk_design,$deco_headline_start,$i);
           	$ed=strpos($wk_design,$deco_headline_end,$i);

            	if($st != false)
             	{
             	      $st += strlen( $deco_headline_start );
                      $tt = $tt ." &nbsp;&nbsp;&nbsp; ". $deco_blit_start . $c .". &nbsp; <a href='#'>". substr( $wk_design , $st , $ed - $st ) . "</a>";
             	      $i = $ed + 1;
             	      $c ++;
                }
                else
                break;
        }

        $wk_design = str_replace("[[TableOfContents]]",$tt, $wk_design);
}


		// font decoration


		// for no-smok style italic - bold decoration

                if( strpos($wk_design,"''") != false && !(strpos($wk_design,"``") != false) )
                {

$j = strlen($wk_design);
$l = 1;
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"''''",$i);
	if($k != false)
	{
                if ( $l == 1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+4);
                               	$wk_design = $forward . " <font size=4> " . $backward;
                }
                if ( $l == -1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+4);
                               	$wk_design = $forward . " </font> " . $backward;
                }

                $l = $l * (-1);
                $i = $k+4;
        }
        else
        break;
}

$j = strlen($wk_design);
$l = 1;
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"'''",$i);
	if($k != false)
	{
                if ( $l == 1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+3);
                               	$wk_design = $forward . " <B> " . $backward;
                }
                if ( $l == -1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+3);
                               	$wk_design = $forward . " </B> " . $backward;
                }

                $l = $l * (-1);
                $i = $k+3;
        }
        else
        break;
}



$j = strlen($wk_design);
$l = 1;
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"''",$i);
	if($k != false)
	{
                if ( $l == 1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+2);
                               	$wk_design = $forward . " <I> " . $backward;
                }
                if ( $l == -1 ) {
                               	$forward =  substr($wk_design,0,$k);
                               	$backward = substr($wk_design,$k+2);
                               	$wk_design = $forward . " </I> " . $backward;
                }
                $l = $l * (-1);
                $i = $k+2;
        }
        else
        break;
}





               }

$wk_design = str_replace("==&gt; OTL &lt;==", "<center><img src='emo_otl.jpg'></center>", $wk_design);
$wk_design = str_replace("==&gt; ������ &lt;==", "<center><img src='emo_ejn.jpg'></center>", $wk_design);
$wk_design = str_replace("==&gt; ", "<center><font size=6 color=red> ", $wk_design);
$wk_design = str_replace(" &lt;==", " </center></font>", $wk_design);
$wk_design = str_replace(" ````"," <font size=5>", $wk_design);
$wk_design = str_replace("'''' ","</font> ", $wk_design);
$wk_design = str_replace(" ```"," <I>",$wk_design);
$wk_design = str_replace("''' ","</I> ",$wk_design);
$wk_design = str_replace(" ``"," <B>",$wk_design);
$wk_design = str_replace("'' ","</B> ",$wk_design);
$wk_design = str_replace(" \"CR","<font color=red>",$wk_design);
$wk_design = str_replace("RC\"","</font>",$wk_design);
$wk_design = str_replace(" \"CB","<font color=blue>",$wk_design);
$wk_design = str_replace("BC\"","</font>",$wk_design);
$wk_design = str_replace(" \"CG","<font color=green>",$wk_design);
$wk_design = str_replace("GC\"","</font>",$wk_design);
$wk_design = str_replace(" \"CY","<font color=yellow>",$wk_design);
$wk_design = str_replace("YC\"","</font>",$wk_design);
$wk_design = str_replace(" \"CP","<font color=pink>",$wk_design);
$wk_design = str_replace("PC\"","</font>",$wk_design);
$wk_design = str_replace(" \"CF","<font color=purple>",$wk_design);
$wk_design = str_replace("FC\"","</font>",$wk_design);
$wk_design = str_replace("\n````"," <font size=5>", $wk_design);
$wk_design = str_replace("''''<","</font><", $wk_design);
$wk_design = str_replace("\n```"," <I>",$wk_design);
$wk_design = str_replace("'''<","</I><",$wk_design);
$wk_design = str_replace("\n``"," <B>",$wk_design);
$wk_design = str_replace("''<","</B><",$wk_design);
$wk_design = str_replace("\n\"CR","<font color=red>",$wk_design);
$wk_design = str_replace("\n\"CB","<font color=blue>",$wk_design);
$wk_design = str_replace("\n\"CG","<font color=green>",$wk_design);
$wk_design = str_replace("\n\"CY","<font color=yellow>",$wk_design);
$wk_design = str_replace("\n\"CP","<font color=pink>",$wk_design);
$wk_design = str_replace("\n\"CF","<font color=purple>",$wk_design);
$wk_design = str_replace("[[ ","<center> ",$wk_design);
$wk_design = str_replace(" ]]"," </center>",$wk_design);
		// smiley decoration
$wk_design = str_replace(" :)", "> ",$wk_design);
$wk_design = str_replace(" B)", "> ",$wk_design);
$wk_design = str_replace(" :))", "> ",$wk_design);
$wk_design = str_replace(" ;)", "> ",$wk_design);
$wk_design = str_replace(" :D", "> ",$wk_design);
$wk_design = str_replace(" <:(", "> ",$wk_design);
$wk_design = str_replace(" X-(", "> ",$wk_design);
$wk_design = str_replace(" :o", "> ",$wk_design);
$wk_design = str_replace(" :(", "> ",$wk_design);
$wk_design = str_replace("{!} ", "> ",$wk_design);
$wk_design = str_replace(" {!}"," <img src=\"aelrt.gif\"> ",$wk_design);
$wk_design = str_replace("(!) ", "> ",$wk_design);
$wk_design = str_replace(" (!)", "> ",$wk_design);
$wk_design = str_replace(" :-/", "> ",$wk_design);
$wk_design = str_replace(" >:>", "> ",$wk_design);
$wk_design = str_replace(" :\\", "> ",$wk_design);
$wk_design = str_replace(" --;", "> ",$wk_design);
$wk_design = str_replace(" - -;", "> ",$wk_design);
$wk_design = str_replace(" ^^", "> ",$wk_design);
$wk_design = str_replace(" ^ ^", "> ",$wk_design);
$wk_design = str_replace(" ^__^", "> ",$wk_design);
$wk_design = str_replace("{V}", "> ",$wk_design);
$wk_design = str_replace("{ok}", "> ",$wk_design);
$wk_design = str_replace("{�׷���}", "> ",$wk_design);
$wk_design = str_replace("{x}", "> ",$wk_design);
$wk_design = str_replace("{i}", "> ",$wk_design);
$wk_design = str_replace("\n----<BR>","<HR>",$wk_design);

//TRICKY
$wk_design = str_replace("!?--TRICK--?!","<img src='me1.jpg' name='mine' onClick='document.mine.src=\"me2.jpg\"' onMouseOut='document.mine.src=\"me1.jpg\"' width=230 height=297>", $wk_design);


		// Hyper Link decoration
$wk_design = str_replace(" [�ձ۴ޱ�]"," <a href=\"index.php?pagetoedit=".$wk_title."&edittype=reply\">��۴ޱ�</a>",$wk_design);
$wk_design = str_replace(" [��۴ޱ�]"," <a href=\"index.php?pagetoedit=".$wk_title."&edittype=reply\">��۴ޱ�</a>",$wk_design);
$wk_design = str_replace("\n[�ձ۴ޱ�]","<a href=\"index.php?pagetoedit=".$wk_title."&edittype=reply\">��۴ޱ�</a>",$wk_design);
$wk_design = str_replace("\n[��۴ޱ�]","<a href=\"index.php?pagetoedit=".$wk_title."&edittype=reply\">��۴ޱ�</a>",$wk_design);

$j = strlen($wk_design); // .google tag processing
for($i=0;$i<$j;$i++){
        $k=strpos($wk_design,"[",$i);
        if($k != false)
        {
                $l = strpos($wk_design,"]",$k);
                $deco_url = substr($wk_design,$k+1,$l-$k-1);
		$deco_url = str_replace("http://","", $deco_url);
		$deco_url = str_replace("LINK:","", $deco_url);
		
		$src_prc = str_replace(" in yahoo", "", $deco_url);
		$src_prc = str_replace(" in nkino", "", $src_prc);

                if(strpos($deco_url," in nkino")!=false) {
               	$src_prc = ("http://search.nkino.com/nkino30/result.asp?keyword=".str_replace(" ","+",$src_prc)); 
		$fp=fopen($src_prc,"r");
		$src_prc = "http://img.yahoo.co.kr/globalnav/ma.gif";
		for($loop=0;$loop<3000;$loop++){
               	$line = fgets($fp);
			if(strpos($line,"http://content.nkino.com/movie/")!=false){ //"http://.co.kr/imgs")!=false){
				$img_i = strpos($line, "http://content.nkino.com/movie/"); //"http://img.srch.yahoo.co.s");
				$img_i = $img_i;
				$img_e = strpos($line, " width", $img_i); //border");
				$src_prc = substr($line, $img_i, $img_e-$img_i);
				break;
			}
			if(strpos($line, "</html>")!=false) {break;}
		}
                fclose($fp);
		
		$src_prc = "<img src=\"".$src_prc."\">";
		$wk_design = str_replace("[".$deco_url."]",$src_prc, $wk_design);
		$wk_design = str_replace("[http://".$deco_url."]",$src_prc, $wk_design);
		$wk_design = str_replace("[LINK:".$deco_url."]",$src_prc, $wk_design); 
		}

                if(strpos($deco_url," in yahoo")!=false) {
                $src_prc = ("http://kr.imagesearch.yahoo.com/search/imgbox?p=".str_replace(" ","+",$src_prc));
                $fp=fopen($src_prc,"r");
                $src_prc = "http://img.yahoo.co.kr/globalnav/ma.gif";
                for($loop=0;$loop<3000;$loop++){
                $line = fgets($fp);
                        if(strpos($line,"http://img.srch.yahoo.co.kr/imgs")!=false){
                                $img_i = strpos($line, "http://img.srch.yahoo.co.kr/imgs");
                                $img_i = $img_i;
                                $img_e = strpos($line, "border", $img_i);
                                $src_prc = substr($line, $img_i, $img_e-$img_i);
                                break;
                        }
                        if(strpos($line, "</html>")!=false) {break;}
                }
                fclose($fp);

                $src_prc = "<img src=\"".$src_prc."\">";
                $wk_design = str_replace("[".$deco_url."]",$src_prc, $wk_design);
                $wk_design = str_replace("[http://".$deco_url."]",$src_prc, $wk_design);
                $wk_design = str_replace("[LINK:".$deco_url."]",$src_prc, $wk_design);
                }

                $j = strlen($wk_design);
                $i = $l;
        } else break;
}
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"[LINK:",$i);
	if($k != false)
	{
		$l = strpos($wk_design,"]",$k);
		$deco_url = substr($wk_design,$k+6,$l-$k-6);
		if(strpos($deco_url,".jpg")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Jpg")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".JPG")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".gif")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Gif")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".GIF")!=false) $wk_design = str_replace("[LINK:".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
			$wk_design = str_replace("[LINK:".$deco_url."]","<a href=\"".$deco_url."\">".$deco_url."</a>",$wk_design);

                $j = strlen($wk_design);
		$i = $l;
	} else break;
}
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design," [http://",$i);
	if($k != false)
	{
		$l = strpos($wk_design,"]",$k);
		$deco_url = substr($wk_design,$k+2,$l-$k-2);
		//echo( $deco_utl );
		if(strpos($deco_url,".jpg")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Jpg")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".JPG")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".gif")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Gif")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".GIF")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
			$wk_design = str_replace("[".$deco_url."]","<a href=\"".$deco_url."\">".$deco_url."</a>",$wk_design);

                $j = strlen($wk_design);
		$i = $l;
	} else break;
}
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"\n[http://",$i);
	if($k != false)
	{
		$l = strpos($wk_design,"]",$k);
		$deco_url = substr($wk_design,$k+2,$l-$k-2);
		if(strpos($deco_url,".jpg")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Jpg")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".JPG")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".gif")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".Gif")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
		if(strpos($deco_url,".GIF")!=false) $wk_design = str_replace("[".$deco_url."]","<img src=\"".$deco_url."\">",$wk_design); else
			$wk_design = str_replace("[".$deco_url."]","<a href=\"".$deco_url."\">".$deco_url."</a>",$wk_design);

                $j = strlen($wk_design);
		$i = $l;
	} else break;
}
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design," [ ",$i);
	if($k != false)
	{
		$l = strpos($wk_design," ]",$k);
		$deco_url = substr($wk_design,$k+3,$l-$k-3);
		$wk_design = str_replace(" [ ".$deco_url." ]"," <a href=\"index.php?pagetoread=".$deco_url."\">".$deco_url."</a> ",$wk_design);

                $j = strlen($wk_design);
		$i = $l;
	} else break;
}
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"[",$i);
	if($k != false)
	{
		$l = strpos($wk_design,"]",$k);
		$deco_url = substr($wk_design,$k+1,$l-$k-1);
		if($deco_url == str_replace(" ","",$deco_url) ) {
		$wk_design = str_replace("[".$deco_url."]"," <a href=\"index.php?pagetoread=".$deco_url."\">".$deco_url."</a> ",$wk_design);
		}

                $j = strlen($wk_design);
		$i = $l;
	} else break;
}


                // Table Decoration
if( strpos($wk_design,"||<BR>\n<BR>") != false ) {

$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"||<BR>",$i);
	if($k != false)
	{
		if( $k == strpos($wk_design,"||<BR>\n<BR>",$i) )
		{
		// end of table
                	$forward =  substr($wk_design,0,$k);
                       	$backward = substr($wk_design,$k+2);
                      	$wk_design = $forward . " </td></tr></table> " . $backward;
                } else
                // end of row
                {
                	$forward =  substr($wk_design,0,$k);
                       	$backward = substr($wk_design,$k+6);
                      	$wk_design = $forward . " </td></tr> " . $backward;
                }

                $i = $k+1;
	} else break;
}

$l = 1;
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"||",$i);
	if($k != false)
	{
		if( strpos($wk_design,"\n||",$i) == $k-1 ){
                  if( $l == 1 || strpos($wk_design," </td></tr></table> ", $k) != $l ) {
		        // start of table
                	$forward =  substr($wk_design,0,$k);
                       	$backward = substr($wk_design,$k+2);
                      	$wk_design = $forward . " <table border=1><tr><td> " . $backward;
                      	$l = strpos($wk_design," </td></tr></table> ",$k);
                    }
                    else {
		        // start of row
                	$forward =  substr($wk_design,0,$k);
                       	$backward = substr($wk_design,$k+2);
                      	$wk_design = $forward . " <tr><td> " . $backward;
                      	$l = strpos($wk_design," </td></tr></table> ",$l-1);
                    }
	       }
		 else
		{
			// middle of row
                	$forward =  substr($wk_design,0,$k);
                       	$backward = substr($wk_design,$k+2);
                      	$wk_design = $forward . " </td><td> " . $backward;
                      	$l = strpos($wk_design," </td></tr></table> ",$l-1);
                }

        $i = $k+1;
	} else break;
}


}

//JSoekaki extention
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
        $k=strpos($wk_design,"@JSoekaki_start@",$i);
        if($k != false)
        {
                $l = strpos($wk_design,"@JSoekaki_end@",$k);
		$picturecode = substr($wk_design, $k+16, $l-$k-16);
		$picturecode = str_replace("{","<TR HEIGHT=5>",$picturecode);
		$picturecode = str_replace("}","</TR>",$picturecode);
		$picturecode = str_replace("w","<TD BGCOLOR=WHITE HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("b","<TD BGCOLOR=BLACK HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("r","<TD BGCOLOR=RED HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("y","<TD BGCOLOR=YELLOW HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("o","<TD BGCOLOR=ORANGE HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("s","<TD BGCOLOR=BLUE HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("g","<TD BGCOLOR=GREEN HEIGHT=5 WIDTH=5></TD>",$picturecode);
                $picturecode = str_replace("d","<TD BGCOLOR=GRAY HEIGHT=5 WIDTH=5></TD>",$picturecode);

		$picturecode = "<table cellspacing=0 cellpadding=0>\n".$picturecode."</table>";
		$wk_design = 
		substr($wk_design,0,$k).
		$picturecode.
		substr($wk_design,$l+14);

                $j = strlen($wk_design);
                $i = $l;
        } else break;
}



// ------ Final output -------

// non decoratble processing
$wk_design = str_replace("--==NONDECO==--", "<table style='background-color: #EEEEC0;text-align:left;padding: 5px;margin: 0px 10px;'><tr style='background-color: #FFFFE0;text-align:left;padding: 5px;margin: 0px 10px;'><td style='background-color: #EEEEC0;text-align:left;padding: 5px;margin: 0px 10px;'><PRE>\n".$nondeco."</PRE></TD></TR></TABLE>", $wk_design);

// Output in fully HTMLized file
if(strpos($HTTP_GET_VARS["option"],"tatic")==1){ // create static HTM file
$wk_design = str_replace("index.php?pagetoread=SEARCH","#",$wk_design);
$wk_design = str_replace("index.php?pagetoread=UPLOAD","#",$wk_design);
$wk_design = str_replace("index.php?pagetoread=TITLELIST","#",$wk_design);
$wk_design = str_replace("index.php?pagetoread=UPDATELIST","#",$wk_design);
$wk_design = str_replace("index.php?pagetoedit=","index.php?pagetoread=",$wk_design);
$wk_design = str_replace("index.php?pagetoedit=�����Է�","#",$wk_design);
$j = strlen($wk_design);
for($i=0;$i<$j;$i++){
	$k=strpos($wk_design,"index.php?pagetoread=",$i);
	if($k != false)
	{
		$l = strpos($wk_design,"\"",$k);
		$l2= strpos($wk_design,"'",$k);
		if($l2<$l && $l2>0) $l=$l2;
		$deco_url = substr($wk_design,$k+21,$l-$k-21);
		$deco_url = str_replace("&option=static"   ,"",$deco_url);
		$deco_url = str_replace("&option=oekaki"   ,"",$deco_url);
		$deco_url = str_replace("&option=trackback","",$deco_url);
		$deco_url = str_replace("&option=oekaki"   ,"",$deco_url);
		$wk_design = str_replace("index.php?pagetoread=".$deco_url,$deco_url.".htm",$wk_design);
                $j = strlen($wk_design);
		$i = $l;
	} else break;
}
//	Writing file
$fp=fopen($wk_title.".htm","wb");
fwrite($fp, $wk_design);
fclose($fp);
if(strpos($filename_to_read,"kct0.txt")==1){
$fp=fopen($wk_title."FIRSTPAGE.htm","wb");
fwrite($fp, $wk_design);
fclose($fp);}
//	Output dump
echo $wk_design;
}
else


// plain output
echo $wk_design;
?>
