
<?php include '../classification/classes/Journal.php'; ?>

<style type="text/css">
<!--
table.morpion
{
    border:        dashed 1px #444444;
}

table.morpion td
{
    font-size:    15pt;
    font-weight:  bold;
    border:       solid 1px #000000;
    padding:      1px;
    text-align:   center;
    width:        25px;
}

table.morpion td.j1 { color: #0A0; }
table.morpion td.j2 { color: #A00; }

-->
</style>
<page style="font-size: 10pt">
  
	<?php 
		$journal = new Journal();
		$journal->convertListJournal("PDF");
	?>
	
</page>