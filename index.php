<!DOCTYPE html>
<html>
<head>
    <title>MySQL Visual Query Builder</title>
</head>
<body>
    <form method="post" action="generate-query.php">
        <div id="tables">
            <div class="table-container">
                <label for="table1">Select Table:</label>
                <select class="table" name="tables[]">
                    <option value="table1">Table 1</option>
                    <option value="table2">Table 2</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
        </div>
        
        <button type="button" id="add-table">Add Table</button>
        
        <div id="joins">
            <div class="join-container">
                <label for="join_type1">Join Type:</label>
                <select class="join-type" name="join_types[]">
                    <option value="LEFT JOIN">Left Join</option>
                    <option value="RIGHT JOIN">Right Join</option>
                    <option value="INNER JOIN">Inner Join</option>
                </select>
                
                <label for="join_table1">Join Table:</label>
                <select class="join-table" name="join_tables[]">
                    <option value="table1">Table 1</option>
                    <option value="table2">Table 2</option>
                    <!-- Add more options as needed -->
                </select>
                
                <label for="join_condition1">Join Condition:</label>
                <input type="text" class="join-condition" name="join_conditions[]" placeholder="Condition">
                
                <button type="button" class="remove-join">Remove Join</button>
            </div>
        </div>
        
        <button type="button" id="add-join">Add Join</button>
        
        <label for="columns">Select Columns:</label>
        <select id="columns" name="columns[]" multiple>
            <option value="column1">Column 1</option>
            <option value="column2">Column 2</option>
            <!-- Add more options as needed -->
        </select>
        
        <div id="conditions">
            <label>Conditions:</label>
            <div class="condition">
                <select class="column" name="condition_columns[]">
                    <option value="column1">Column 1</option>
                    <option value="column2">Column 2</option>
                    <!-- Add more options as needed -->
                </select>
                <select class="operator" name="condition_operators[]">
                    <option value="=">=</option>
                    <option value=">">></option>
                    <option value="<"><</option>
                    <!-- Add more operators as needed -->
                </select>
                <input type="text" class="value" name="condition_values[]" placeholder="Value">
                <button type="button" class="remove-condition">Remove</button>
            </div>
        </div>
        
        <button type="button" id="add-condition">Add Condition</button>
        <button type="submit">Generate Query</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>


<?php
// Retrieve the form data
$tables = $_POST['tables'];
$joinTypes = $_POST['join_types'];
$joinTables = $_POST['join_tables'];
$joinConditions = $_POST['join_conditions'];
$columns = $_POST['columns'];
$conditionColumns = $_POST['condition_columns'];
$conditionOperators = $_POST['condition_operators'];
$conditionValues = $_POST['condition_values'];

// Construct the SELECT statement
$query = "SELECT ";

// Add selected columns
$query .= implode(", ", $columns);

// Add the first table
$query .= " FROM " . $tables[0];

// Add join clauses if any
if (count($joinTables) > 0) {
    for ($i = 0; $i < count($joinTables); $i++) {
        $joinType = $joinTypes[$i];
        $joinTable = $joinTables[$i];
        $joinCondition = $joinConditions[$i];
        
        $query .= " " . $joinType . " " . $joinTable . " ON " . $joinCondition;
    }
}

// Add conditions if any
if (!empty($conditionColumns) && !empty($conditionOperators) && !empty($conditionValues)) {
    $query .= " WHERE ";
    $conditions = array();
    for ($i = 0; $i < count($conditionColumns); $i++) {
        $column = $conditionColumns[$i];
        $operator = $conditionOperators[$i];
        $value = $conditionValues[$i];
        $conditions[] = $column . " " . $operator . " '" . $value . "'";
    }
    $query .= implode(" AND ", $conditions);
}

// Output the generated query
echo $query;
?>

$(document).ready(function() {
  // Add Table
  $("#add-table").click(function() {
    var tableContainer = $("<div class='table-container'></div>");
    var selectTable = $("<select class='table' name='tables[]'></select>");

    // Add options for tables
    selectTable.append("<option value='table1'>Table 1</option>");
    selectTable.append("<option value='table2'>Table 2</option>");
    // Add more options as needed

    tableContainer.append("<label for='table'>Select Table:</label>");
    tableContainer.append(selectTable);
    $("#tables").append(tableContainer);
  });

  // Add Join
  $("#add-join").click(function() {
    var joinContainer = $("<div class='join-container'></div>");
    var selectJoinType = $("<select class='join-type' name='join_types[]'></select>");
    var selectJoinTable = $("<select class='join-table' name='join_tables[]'></select>");
    var inputJoinCondition = $("<input type='text' class='join-condition' name='join_conditions[]' placeholder='Condition'>");

    // Add options for join type
    selectJoinType.append("<option value='LEFT JOIN'>Left Join</option>");
    selectJoinType.append("<option value='RIGHT JOIN'>Right Join</option>");
    selectJoinType.append("<option value='INNER JOIN'>Inner Join</option>");

    // Add options for join tables
    selectJoinTable.append("<option value='table1'>Table 1</option>");
    selectJoinTable.append("<option value='table2'>Table 2</option>");
    // Add more options as needed

    joinContainer.append("<label for='join_type'>Join Type:</label>");
    joinContainer.append(selectJoinType);
    joinContainer.append("<label for='join_table'>Join Table:</label>");
    joinContainer.append(selectJoinTable);
    joinContainer.append("<label for='join_condition'>Join Condition:</label>");
    joinContainer.append(inputJoinCondition);
    joinContainer.append("<button type='button' class='remove-join'>Remove Join</button>");

    $("#joins").append(joinContainer);
  });

  // Remove Join
  $(document).on("click", ".remove-join", function() {
    $(this).parent().remove();
  });

  // Add Condition
  $("#add-condition").click(function() {
    var conditionContainer = $("<div class='condition'></div>");
    var selectColumn = $("<select class='column' name='condition_columns[]'></select>");
    var selectOperator = $("<select class='operator' name='condition_operators[]'></select>");
    var inputConditionValue = $("<input type='text' class='value' name='condition_values[]' placeholder='Value'>");

    // Add options for condition column
    selectColumn.append("<option value='column1'>Column 1</option>");
    selectColumn.append("<option value='column2'>Column 2</option>");
    // Add more options as needed

    // Add options for condition operator
    selectOperator.append("<option value='='>=</option>");
    selectOperator.append("<option value='>'>></option>");
    selectOperator.append("<option value='<'><</option>");
    // Add more operators as needed

    conditionContainer.append(selectColumn);
    conditionContainer.append(selectOperator);
    conditionContainer.append(inputConditionValue);
    conditionContainer.append("<button type='button' class='remove-condition'>Remove</button>");

    $("#conditions").append(conditionContainer);
  });

  // Remove Condition
  
// Remove Condition
$(document).on("click", ".remove-condition", function() {
  $(this).parent().remove();
});
});
