<x-mail::message>
# Introduction

Thanks for subscribe !!!

<x-mail::button :url="route('frontend.index')">
Visit Our WebSite
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
