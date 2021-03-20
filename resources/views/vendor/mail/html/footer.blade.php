<tr style="margin-top: 40px;">
    <td style="background: #000;">
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="background: #000; color: #fff;">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
