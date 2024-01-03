<?php
/*
Plugin Name: Adzuna Jobs Integration
Description: Integrates Adzuna job listings into WordPress.
Version: 1.0
Author: Kuda Zafevere
Plugin URI: https://github.com/trixxmanaty/adzuna-jobs-integration
*/

// Enqueue Styles and Scripts
function adzuna_enqueue_scripts() {
    wp_enqueue_style('bulma-css', 'https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css');
    wp_enqueue_script('jquery');
    wp_enqueue_script('adzuna-ajax-script', plugin_dir_url(__FILE__) . 'js/adzuna-ajax.js', array('jquery'), null, true);
    wp_localize_script('adzuna-ajax-script', 'adzunaAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'adzuna_enqueue_scripts');

// Shortcode for Job Search Form
function adzuna_job_search_form() {
    ob_start();
    ?>
    <div class='box has-background-danger-light'>
        <h1 class="title is-4">Land Your Dream Job with Adzuna's Effortless Search Engine</h1>
        <p class="subtitle is-5">Say goodbye to endless job boards and scattered applications. Adzuna's sleek search engine cuts through the noise, connecting you with your perfect career match in seconds. Simply enter your desired keywords or job title, and watch our curated list of relevant opportunities unfold. Filter by location, salary, and company, then dive into detailed descriptions to find the perfect fit. No more sifting through irrelevant postings, just seamless navigation and a streamlined path to landing your dream job. Start your journey today and let Adzuna be your guide to a fulfilling career.</p>
        <form id="adzuna-job-search-form">
            <div class="field">
                <label class="label">Enter Job Title:</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Accountant" required>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input class="button is-success" type="submit" value="Search">
                </div>
            </div>
        </form>
        <div id="results"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('adzuna_job_search', 'adzuna_job_search_form');

// AJAX Function for Searching Jobs
function adzuna_ajax_search_jobs() {
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';

    // Replace with your actual API keys
    $app_id = 'YourAppIDHere';
    $app_key = 'YourAppKeyHere';
    $url = "https://api.adzuna.com/v1/api/jobs/us/search/1?app_id={$app_id}&app_key={$app_key}&what=" . urlencode($title);

    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        echo "Error fetching jobs";
    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!empty($data) && isset($data['results'])) {
            foreach ($data['results'] as $job) {
                echo "<div class='job-listing'>";
                echo "<h3>" . esc_html($job['title']) . "</h3>";
                echo "<p>Company: " . esc_html($job['company']['display_name']) . "</p>";
                echo "<p>Salary: $" . esc_html($job['salary_min']) . " - $" . esc_html($job['salary_max']) . "</p>";
                echo "<a class='button is-primary' href='" . esc_url($job['redirect_url']) . "'>Apply</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No results found for '" . esc_html($title) . "'.</p>";
        }
    }

    wp_die();
}
add_action('wp_ajax_nopriv_adzuna_search_jobs', 'adzuna_ajax_search_jobs');
add_action('wp_ajax_adzuna_search_jobs', 'adzuna_ajax_search_jobs');
