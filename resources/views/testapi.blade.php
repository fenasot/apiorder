<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API POST Test Tool</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #ddd4b9;
        }

        input {
            width: 250px;
        }

        textarea {
            width: 350px;
            height: 200px;
        }
    </style>
</head>

<body>
    <h1>API POST Test Tool</h1>

    <form id="postForm">
        <label for="url">API URL:</label>
        <input type="text" id="url" placeholder="http://localhost:8080/api/orders" value="http://localhost:8080/api/orders" required>

        <p></p>

        <div>
            <div><label for="jsonData">JSON Data:</label></div>
            <div><textarea id="jsonData" rows="5" placeholder='{"key": "value"}' required></textarea></div>
        </div>



        <p></p>

        <button type="submit">Send POST Request</button>
    </form>

    <h2>Response:</h2>
    <pre id="response"></pre>

    <script>
        $(document).ready(function() {
            $('#postForm').on('submit', function(event) {
                event.preventDefault(); // 防止表單提交

                const url = $('#url').val();
                const jsonData = $('#jsonData').val();

                $.ajax({
                    url: url,
                    method: 'POST',
                    contentType: 'application/json',
                    data: jsonData,
                    success: function(response) {
                        $('#response').text(JSON.stringify(response, null, 2));
                    },
                    error: function(xhr) {
                        $('#response').text(`Error: ${xhr.status} ${xhr.statusText}`);
                    }
                });
            });
        });
    </script>
</body>

</html>