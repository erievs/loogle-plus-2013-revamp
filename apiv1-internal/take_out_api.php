
<?php
/*
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$response = array();

include("../important/db.php");

function convertToLatinCollation($string) {
    return iconv('utf8mb4', 'latin1//TRANSLIT', $string);
}

function parseHTMLFiles($zipFile, $conn) {
    $data = array();
    $randomDir = "../takeout-storage/" . uniqid();
    mkdir($randomDir);

    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        // Extracts the ZIP file
        $zip->extractTo($randomDir);
        $zip->close(); 

        // Checks if the "Posts" folder exists
        if (!is_dir("$randomDir/Posts")) {
            return array(
                'status' => 'error',
                'message' => 'No "Posts" folder found in the ZIP file.'
            );
        }

        $htmlFiles = glob("$randomDir/Posts/*.html");

        if (empty($htmlFiles)) {
            return array(
                'status' => 'error',
                'message' => 'No HTML files found in the Posts folder.'
            );
        }

        foreach ($htmlFiles as $file) {
            $dom = new DOMDocument();
            @$dom->loadHTMLFile($file);

            $usernameElement = $dom->getElementsByTagName('span')->item(3);
            if ($usernameElement) {
                $username = convertToLatinCollation($usernameElement->nodeValue);
            }

            $dateModifiedElement = $dom->getElementsByTagName('span')->item(5);
            if ($dateModifiedElement) {
                $dateModified = $dateModifiedElement->nodeValue;
                $dateTime = DateTime::createFromFormat('Y-m-d\TH:i:sO', str_replace('T', '', $dateModified));
                if ($dateTime !== false) {
                    $dateModified = $dateTime->format('Y-m-d H:i:s');
                } else {
                    $dateModified = '1970-01-01 00:00:00';
                }
            } else {
                $dateModified = '1970-01-01 00:00:00';
            }

            $mainContentElement = $dom->getElementsByTagName('div')->item(1);
            if ($mainContentElement) {
                $mainContent = convertToLatinCollation($mainContentElement->textContent);
            }

            $imageElement = $dom->getElementsByTagName('img')->item(0);
            $imageURL = null;
            if ($imageElement) {
                $imageURL = $imageElement->getAttribute('src');
            }

            if ($mainContent || $imageURL) {
                $query = "INSERT INTO posts (username, content, image_url, created_at) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    return array(
                        'status' => 'error',
                        'message' => 'Failed to prepare SQL statement.'
                    );
                }
                $stmt->bind_param("ssss", $username, $mainContent, $imageURL, $dateModified);
                $executeResult = $stmt->execute();
                if (!$executeResult) {
                    return array(
                        'status' => 'error',
                        'message' => 'Failed to execute SQL statement.'
                    );
                }

                $data[] = array(
                    "dateModified" => $dateModified,
                    "name" => $username,
                    "mainContent" => $mainContent,
                    "imageURL" => $imageURL
                );
            }
        }

        // Clean up: delete extracted files and directories
        array_map('unlink', glob("$randomDir/Posts/*"));
        rmdir("$randomDir/Posts");
        rmdir($randomDir);

        return array(
            'status' => 'success',
            'data' => $data
        );
    } else {
        return array(
            'status' => 'error',
            'message' => 'Failed to open zip file.'
        );
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $zipFile = $_FILES['file']['tmp_name'];

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_error) {
            $response['status'] = 'error';
            $response['message'] = "Connection failed: " . $conn->connect_error;
            echo json_encode($response);
            exit;
        }

        $parsedData = parseHTMLFiles($zipFile, $conn);

        if ($parsedData['status'] === 'success') {
            $response['status'] = 'success';
            $response['data'] = $parsedData['data'];
        } else {
            $response['status'] = 'error';
            $response['message'] = $parsedData['message'];
        }

        $conn->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to upload file.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
*/
?>
