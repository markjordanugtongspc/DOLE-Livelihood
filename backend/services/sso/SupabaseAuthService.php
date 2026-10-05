<?php
namespace App\services\sso;

/* START: SupabaseAuthService — future integration driver for Supabase SSO */
class SupabaseAuthService
{
    private string $supabaseUrl;
    private string $anonKey;
    private bool $isEnabled;

    /* START: __construct — initialize Supabase parameters */
    public function __construct()
    {
        $this->supabaseUrl = $_ENV['SUPABASE_URL'] ?? '';
        $this->anonKey     = $_ENV['SUPABASE_ANON_KEY'] ?? '';
        $this->isEnabled   = filter_var($_ENV['SSO_SUPABASE_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }
    /* END: __construct */

    /* START: isAvailable — checks if Supabase SSO is enabled and configured */
    public function isAvailable(): bool
    {
        return $this->isEnabled && !empty($this->supabaseUrl) && !empty($this->anonKey);
    }
    /* END: isAvailable */

    /* START: getRedirectUrl — placeholder for provider OAuth authorization URL */
    public function getRedirectUrl(string $provider = 'google'): string
    {
        return "{$this->supabaseUrl}/auth/v1/authorize?provider={$provider}";
    }
    /* END: getRedirectUrl */
}
/* END: SupabaseAuthService */
