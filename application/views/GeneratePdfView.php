<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF</title>
	
	<style>
		table {
		border: 1px solid black;
		}
		th, td {
		border: 1px solid black;
		width: 100px;
		}
	</style>
</head>
<body>
<h3>My Courses List</h3>
	<table>
		<tr>
			<th>ID</th>
			<th>Course Name</th>
			<th>Course ID</th>
			<th>Year</th>
			<th>Semester</th>
		</tr>
		<?php foreach($myCourses as $row){
			echo '
			<tr>
				<td>'.$row->idz.'</td>
				<td>'.$row->name.'</td>
				<td>'.$row->course_id.'</td>
				<td>'.$row->year.'</td>
				<td>'.$row->semester.'</td>
			</tr>';
		}?>
	</table>
</body>
</html>
