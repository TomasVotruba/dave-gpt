<!DOCTYPE html>
<html>
<head>
    <title>Textarea Form</title>
</head>
<body>
<form method="post" action="/">
    <label for="textarea">Type your question:</label><br>
    <textarea id="textarea" name="question" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php

require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['question'])) {
    $question = $_POST["question"];
    $answer = generate_answer_with_gpt($question);
    echo "<h1>Your question was: $question <br></h1>" . PHP_EOL;
    echo "<h2>The answer is: $answer</h2>";
}

function generate_answer_with_gpt(string $question)
{
    // find token here https://platform.openai.com/account/api-keys
    $client = OpenAI::client('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');

    try {
        $response = $client->completions()->create([
            // @see https://platform.openai.com/docs/models/model-endpoint-compatability
            'model' => 'text-davinci-003',
            'prompt' => $question
        ]);

        return $response->choices[0]->text;
    } catch (Exception $exception) {
        dump($exception);
    }
}

// run this script in your bash like:
// php -S localhost:8000