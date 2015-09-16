		<style type="text/css">
		<!--
		td {
		  padding:5px; 
		  word-wrap:break-word;
		} 
		
		th {
		  padding:4px; 
		} 
		
		table {
			table-layout:fixed;
		} 
		
		.tbold {
			font-weight: bold;
		} 
		
		
		-->
		</style>

		<table cellspacing="3px" style="margin:20px;max-width: 100%; solid;position: relative;">
             <tr>
			<td class="tbold" width="100px;">Year</td><td><?php echo $_GET['y']; ?></td>
             </tr>
            <tr>
			<td class="tbold">Dicipline</td><td><?php echo $_GET['d']; ?></td>
              </tr>
			  <tr>
				<td class="tbold">Form Category</td><td><?php echo $_GET['f']; ?></td>
              </tr>
			  <tr>
				<td class="tbold">Full Mark</td><td><?php echo $fullMarks; ?></td>
              </tr>
			  <?php if($_GET['s'] != "") { ?>
			  <tr>
				<td class="tbold">Search</td><td><?php echo $_GET['s']; ?></td>
              </tr>
			  <?php } ?>
		</table>
		
		
		
            <table cellspacing="3px" style="width: 100%; border:1px solid;margin:20px;" class="table-list">
              <tr bgcolor="#999999">
                <th rowspan="2">No.</th>
                <th rowspan="2" >Journal Title</th>
                <th colspan="4" align="center">Score</th>
               
              </tr>
              <tr>
                <th>Wajib</th>
                <th>Optional</th>
                <th>Total</th>
                <th>%</th>
              </tr>
              <?php $i = $offset ?>
              <?php 
			  
						$section = 1;
						// variables to keep number of journal have for each level
                        $counts = [0, 0, 0, 0, 0];

                        // to keep the threshold value of each level
                        $classes = [90, 70, 30, 20, 10];

                        // labels for each levels
                        $levels = ['A1', 'A2', 'B1', 'B2', 'B5'];

                        $curentLevel = '';
			  
			  ?>
              <?php foreach ($journals as $journal): ?>
			  <?php $percentage = round(($journal['totalMarks'] / $fullMarks) * 100, 2) ?>
			  <?php
                            for ($k = 0; $k < count($classes); $k++) {
                                if ($percentage >= $classes[$k]) {
                                    $counts[$k]++;
                                    if ($currentLevel != $levels[$k]) {
                                        echo '
                                        <tr class="section" bgcolor="#FFDB4D">
                                            <td></td>
                                            <td colspan="6">Tahap ' . $levels[$k] . '</td>
                                        </tr>
                                        ';

                                        $currentLevel = $levels[$k];
                                    }
                                    break;
                                }
                            }

                            ?>
              <!--<?php if ($i % 10 == 0) : ?>
              <tr bgcolor="#FFDB4D">
                  <td></td>
                  <td colspan="6">Tahap A<?php echo $section++ ?></td>
              </tr>
              <?php endif ?>-->
              <tr bgcolor="#E6E6E6">
                <td><?php echo ++$i ?></td>
                <td style="width: 65%; text-align: left;"><?php echo $journal['name'] ?></td>
                <td><?php echo $journal['compulsory'] ?></td>
                <td><?php echo $journal['optional'] ?></td>
                <td><?php echo $journal['totalMarks'] ?></td>
                <td><?php echo $percentage ?></td>
                     
              </tr>
              <?php endforeach; ?>
            </table>
	
    