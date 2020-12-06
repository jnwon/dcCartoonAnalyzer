<!DOCTYPE HTML>
<HEAD>
<TITLE> New Document </TITLE>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
</HEAD>

<BODY>

<table id="example" class="display">
			    <thead>
			        <tr>
			            <th>제목</th>
			            <th>날짜</th>
			            <th>조회</th>
			            <th>추천</th>
			            <th>비추천</th>
			            <th>개비추비율</th>
			            <th>어그로지수</th>
			            <th>충성도</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<tr>
			            <td>제목 1</td>
			            <td>2018-11-11 11:11:11</td>
			            <td>1</td>
			            <td>2</td>
			            <td>3</td>
			            <td>0.058</td>
			            <td>2.262</td>
			            <td>1.00</td>
			        </tr>
			        <tr>
			            <td>제목 1</td>
			            <td>2019-11-11 11:11:11</td>
			            <td>11</td>
			            <td>22</td>
			            <td>33</td>
			            <td>0.058</td>
			            <td>2.262</td>
			            <td>1.90</td>
			        </tr>
			    </tbody>
			</table>

</BODY>
</HTML>