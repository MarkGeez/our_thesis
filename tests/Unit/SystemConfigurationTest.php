<?php

namespace Tests\Unit;

use Tests\TestCase;

class SystemConfigurationTest extends TestCase
{
    public function test_smtp_mail_configuration_is_set_for_system_delivery(): void
    {
        $this->assertContains(config('mail.default'), ['smtp', 'array']);
        $this->assertSame('smtp', config('mail.mailers.smtp.transport'));
        $this->assertSame('mail.smtp2go.com', config('mail.mailers.smtp.host'));
        $this->assertSame(2525, (int) config('mail.mailers.smtp.port'));

        $username = (string) config('mail.mailers.smtp.username');
        $password = (string) config('mail.mailers.smtp.password');
        $fromAddress = (string) config('mail.from.address');

        $this->assertNotSame('', trim($username));
        $this->assertNotSame('', trim($password));
        $this->assertNotSame('', trim($fromAddress));
        $this->assertNotSame('your_smtp_username', $username);
        $this->assertNotSame('your_smtp_password', $password);
        $this->assertMatchesRegularExpression('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $fromAddress);
    }
}
