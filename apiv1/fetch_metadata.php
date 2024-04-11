<?php
$url = isset($_GET['url']) ? $_GET['url'] : '';
$outputFormat = isset($_GET['format']) ? $_GET['format'] : 'html';

if (!empty($url)) {
    $metadata = get_metadata($url);

    if ($outputFormat === 'json') {
        header('Content-Type: application/json');
        echo json_encode($metadata);
    } else {
        if (isset($metadata['error'])) {
            echo $metadata['error'];
        } else {
            if (isset($metadata['image'])) {
                echo '<img src="' . $metadata['image'] . '">';
            }
            if (isset($metadata['title'])) {
                echo '<h1>' . $metadata['title'] . '</h1>';
            }
        }
    }
} else {
    echo "No URL provided.";
}

function get_metadata($url, $path = '../metadata-storage/') {
    $data = array();

    $html = fetch_html($url);
    if ($html) {
        $title = extract_title($html);
        $image = fetch_largest_image($html, $url);
        if (!$image) {
            $image = save_favicon($url, $path);
        }

        $data['title'] = $title;
        $data['image'] = $image;
    } else {
        $data['error'] = "Failed to fetch URL.";
    }

    return $data;
}

function fetch_html($url) {
    $html = @file_get_contents($url);
    if ($html === FALSE) {
        return FALSE;
    }
    return $html;
}

function extract_title($html) {
    $matches = array();
    preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}

function fetch_largest_image($html, $url) {
    $doc = new DOMDocument();
    if (@$doc->loadHTML($html)) {
        $images = $doc->getElementsByTagName('img');
        $largestImage = null;
        $largestSize = 0;

        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            $size = get_image_size($src);
            if ($size > $largestSize) {
                $largestSize = $size;
                $largestImage = $src;
            }
        }

        if ($largestImage) {
            return $largestImage;
        }
    }
    return false;
}

function get_image_size($url) {
    $headers = @get_headers($url, true);
    if ($headers && isset($headers['Content-Length'])) {
        return (int)$headers['Content-Length'];
    } else {
        return 0;
    }
}

function save_favicon($url, $path = '../metadata-storage/') {
    $url = parse_url($url, PHP_URL_HOST);
    $file = $path . $url . '.png';
    if (!file_exists($file)) {
        $fp = fopen($file, 'w+');
        $ch = curl_init('http://www.google.com/s2/favicons?domain=' . $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
    return $file;
}
?>
