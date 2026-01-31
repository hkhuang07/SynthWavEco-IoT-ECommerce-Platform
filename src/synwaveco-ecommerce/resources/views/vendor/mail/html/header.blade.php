@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="https://coderthemes.com/cartzilla/assets/app-icons/icon-180x180.png" class="logo" />
            <br />
            {{ $slot }}
        </a>
    </td>
</tr>