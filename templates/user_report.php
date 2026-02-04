<table style="border-collapse: collapse; width: 100%; max-width: 600px; margin: 40px auto;">
    <tr>
        <td
            style="border: 3px solid #007bff; padding: 30px; background: #f8f9fa; border-radius: 10px; text-align: center;">
            <h1 style="color: #007bff; margin: 0 0 25px 0; font-family: Arial; font-size: 28px;">User Report</h1>

            <table style="width: 100%; margin: 0 auto; font-family: Arial;">
                <tr>
                    <td style="padding: 2px 0; font-size: 16px; border-bottom: 1px solid #dee2e6;">
                        <strong style="color: #495057;">ID:</strong>
                        <span style="color: #007bff; font-weight: bold;"><?= $this->e($user->id) ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-size: 16px; border-bottom: 1px solid #dee2e6;">
                        <strong style="color: #495057;">Name:</strong>
                        <span style="color: #28a745; font-weight: bold;"><?= $this->e($user->name) ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 0; font-size: 16px;">
                        <strong style="color: #495057;">Role:</strong>
                        <span style="color: #28a745; font-weight: bold;"><?= $this->e($user->role) ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 0; font-size: 16px;">
                        <p style="text-align: center; font-size: 14px; color: #666; margin-bottom: 20px;">
                            Report Date: <?= $reportDate ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>