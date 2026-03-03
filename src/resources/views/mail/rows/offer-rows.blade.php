@if (! empty($form->recordable->offer))
@if (! empty($form->recordable->offer->clinic_title))
| Клиника | {{ $form->recordable->offer->clinic_title }} |
@endif
@if (! empty($form->recordable->offer->service_title))
| Услуга | {{ $form->recordable->offer->service_title }} |
@endif
@if (! empty($form->recordable->offer->department_title))
| Специальность | {{ $form->recordable->offer->department_title }} |
@endif
@if (! empty($form->recordable->offer->price))
| Цена | {{ $form->recordable->offer->human_price }} |
@endif
@endif
