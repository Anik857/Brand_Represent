<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Settings
        Setting::set('app_name', 'Brand Represent', 'string', 'general', 'Application name', true);
        Setting::set('app_description', 'Your trusted brand representation platform', 'string', 'general', 'Application description', true);
        Setting::set('app_url', 'http://localhost:8000', 'string', 'general', 'Application URL', true);
        Setting::set('app_timezone', 'UTC', 'string', 'general', 'Application timezone');
        Setting::set('app_language', 'en', 'string', 'general', 'Default language');
        Setting::set('maintenance_mode', false, 'boolean', 'general', 'Enable maintenance mode');

        // Email Settings
        Setting::set('mail_driver', 'smtp', 'string', 'email', 'Mail driver');
        Setting::set('mail_host', 'smtp.gmail.com', 'string', 'email', 'SMTP host');
        Setting::set('mail_port', '587', 'integer', 'email', 'SMTP port');
        Setting::set('mail_username', '', 'string', 'email', 'SMTP username');
        Setting::set('mail_password', '', 'string', 'email', 'SMTP password');
        Setting::set('mail_encryption', 'tls', 'string', 'email', 'Mail encryption');
        Setting::set('mail_from_address', 'noreply@brandrepresent.com', 'string', 'email', 'From email address');
        Setting::set('mail_from_name', 'Brand Represent', 'string', 'email', 'From name');
        Setting::set('mail_enabled', true, 'boolean', 'email', 'Enable email notifications');

        // Payment Settings
        Setting::set('payment_gateway', 'stripe', 'string', 'payment', 'Payment gateway');
        Setting::set('stripe_public_key', '', 'string', 'payment', 'Stripe public key');
        Setting::set('stripe_secret_key', '', 'string', 'payment', 'Stripe secret key');
        Setting::set('stripe_webhook_secret', '', 'string', 'payment', 'Stripe webhook secret');
        Setting::set('currency', 'USD', 'string', 'payment', 'Default currency', true);
        Setting::set('currency_symbol', '$', 'string', 'payment', 'Currency symbol', true);
        Setting::set('payment_enabled', true, 'boolean', 'payment', 'Enable payments');

        // System Settings
        Setting::set('max_file_size', '2048', 'integer', 'system', 'Maximum file size in KB');
        Setting::set('allowed_file_types', 'jpg,jpeg,png,gif,pdf,doc,docx', 'string', 'system', 'Allowed file types');
        Setting::set('session_timeout', '120', 'integer', 'system', 'Session timeout in minutes');
        Setting::set('max_login_attempts', '5', 'integer', 'system', 'Maximum login attempts');
        Setting::set('password_min_length', '8', 'integer', 'system', 'Minimum password length');
        Setting::set('require_email_verification', true, 'boolean', 'system', 'Require email verification');
        Setting::set('enable_registration', true, 'boolean', 'system', 'Enable user registration');
        Setting::set('enable_2fa', false, 'boolean', 'system', 'Enable two-factor authentication');

        // Notification Settings
        Setting::set('notification_email', true, 'boolean', 'notifications', 'Enable email notifications');
        Setting::set('notification_sms', false, 'boolean', 'notifications', 'Enable SMS notifications');
        Setting::set('notification_push', true, 'boolean', 'notifications', 'Enable push notifications');
        Setting::set('notification_slack', false, 'boolean', 'notifications', 'Enable Slack notifications');
        Setting::set('slack_webhook_url', '', 'string', 'notifications', 'Slack webhook URL');

        // Social Media Settings
        Setting::set('facebook_url', '', 'string', 'social', 'Facebook page URL', true);
        Setting::set('twitter_url', '', 'string', 'social', 'Twitter profile URL', true);
        Setting::set('instagram_url', '', 'string', 'social', 'Instagram profile URL', true);
        Setting::set('linkedin_url', '', 'string', 'social', 'LinkedIn profile URL', true);
        Setting::set('youtube_url', '', 'string', 'social', 'YouTube channel URL', true);

        // Analytics Settings
        Setting::set('google_analytics_id', '', 'string', 'analytics', 'Google Analytics ID');
        Setting::set('google_tag_manager_id', '', 'string', 'analytics', 'Google Tag Manager ID');
        Setting::set('facebook_pixel_id', '', 'string', 'analytics', 'Facebook Pixel ID');
        Setting::set('analytics_enabled', true, 'boolean', 'analytics', 'Enable analytics tracking');

        $this->command->info('Settings seeded successfully!');
    }
}