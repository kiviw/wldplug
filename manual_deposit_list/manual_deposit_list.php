<?php
/**
 * Plugin Name: Manual Deposit List
 * Plugin URI: Your plugin website URL
 * Description: A plugin for displaying a list of manual deposit transactions.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: Your website URL
 * Text Domain: manual-deposit-list
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Register shortcode to display the deposit transactions list
function manual_deposit_transactions_list_shortcode() {
    ob_start();
    global $wpdb;
    $table_name = $wpdb->prefix . 'deposit_requests';
    $transactions = $wpdb->get_results("SELECT mpesa_name, amount_in_wld, status FROM $table_name ORDER BY id DESC");

    if ($transactions) {
        echo '<table class="manual-deposit-transactions-list">';
        echo '<thead><tr><th>Name</th><th>Amount in KSH</th><th>Status</th></tr></thead>';
        echo '<tbody>';
        foreach ($transactions as $transaction) {
            $amount_in_ksh = $transaction->amount_in_wld * 210; // Conversion rate: 1 WLD = 210 KSH
            echo '<tr>';
            echo '<td>' . $transaction->mpesa_name . '</td>';
            echo '<td>' . $amount_in_ksh . '</td>';
            echo '<td>' . $transaction->status . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No deposit transactions found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('manual_deposit_transactions_list', 'manual_deposit_transactions_list_shortcode');
