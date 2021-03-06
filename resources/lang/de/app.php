<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

return [
    'register' => 'Registrieren',
    'login' => 'Login',
    'no_account_yet' => 'Noch kein Account? Registrieren',
    'recover_password' => 'Password wiederherstellen',
    'email' => 'E-Mail',
    'cancel' => 'Abbrechen',
    'register_username' => 'Name',
    'register_email' => 'E-Mail',
    'register_password' => 'Passwort',
    'register_password_confirmation' => 'Passwort Bestätigung',
    'password' => 'Passwort',
    'imprint' => 'Impressum',
    'tos' => 'Nutzungsbedingungen',
    'contact' => 'Kontakt',
    'news' => 'News',
    'faq' => 'FAQ',
    'latest_members' => 'Neuste Mitglieder',
    'not_logged_in' => 'Du bist nicht eingeloggt',
    'pw_recovery_ok' => 'Eine E-Mail mit weiteren Details wurde an die angegebene E-Mail Adresse gesendet.',
    'password_reset_ok' => 'Das Passwort wurde erfolgreich zurückgesetzt. Du kannst dich jetzt mit deinem neuen Passwort anmelden.',
    'register_confirm_email' => 'Dein Konto wurde erstellt! Bitte bestätige jetzt noch deine E-Mail Adresse bevor du dich anmeldest. <a href="' . url('/resend') . '/:id">Bestätigungs-Link neu anfordern</a>',
    'resend_ok' => 'Bestätigungs-Nachricht wurde erneut gesendet. <a href="' . url('/resend') . '/:id">Nochmal</a>.',
    'register_confirmed_ok' => 'Dein Konto wurde bestätigt. Viel Spaß nun!',
    'user_id_not_found_or_already_confirmed' => 'Benutzer:in nicht gefunden oder bereits bestätigt: :id',
    'password_confirm' => 'Passwort Bestätigung',
    'password_reset' => 'Passwort zurücksetzen',
    'reset' => 'Zurücksetzen',
    'profiles' => 'Mitglieder',
    'members' => 'Mitglieder',
    'random' => 'Zufall',
    'messages' => 'Nachrichten',
    'notifications' => 'Benachrichtigungen',
    'settings' => 'Einstellungen',
    'enteremail' => 'E-Mail angeben',
    'enterpassword' => 'Gib ein Passwort ein',
    'login_successful' => 'Du bist jetzt eingeloggt!',
    'logout_successful' => 'Du wurdest abgemeldet!',
    'logout' => 'Logout',
    'profiles_title' => 'Finde andere Mitglieder',
    'toggle_filter' => 'Filter',
    'geo_range' => 'Geographische Entfernung',
    'gender_male' => 'Männlich',
    'gender_female' => 'Weiblich',
    'gender_diverse' => 'Divers',
    'age_range' => 'Altersbereich',
    'from' => 'Von',
    'till' => 'Bis',
    'genders' => 'Geschlechter',
    'only_online_profiles' => 'Nur Nutzer anzeigen, die online sind',
    'only_verified_profiles' => 'Nur verifizierte Profile anzeigen',
    'search' => 'Suchen',
    'no_more_profiles' => 'Keine weiteren Profile gefunden',
    'create' => 'Erstellen',
    'no_messages' => 'Keine Nachrichten gefunden',
    'type_something' => 'Gib etwas ein...',
    'username' => 'Benutzername',
    'subject' => 'Betreff',
    'text' => 'Text',
    'message_thread' => 'Unterhaltung mit :name',
    'send' => 'Senden',
    'message_sent' => 'Die Nachricht wurde gesendet',
    'user_not_found_or_deactivated' => 'Benutzer:in nicht gefunden oder deaktiviert',
    'profile' => 'Profil',
    'no_introduction_specified' => 'Keine Beschreibung angegeben',
    'no_information_specified' => 'Keine Informationen angegeben',
    'message' => 'Nachricht',
    'report' => 'Melden',
    'ignore' => 'Ignorieren',
    'age' => 'Alter',
    'gender' => 'Geschlecht',
    'location' => 'Ort',
    'relationship_status' => 'Beziehungsstatus',
    'height' => 'Größe',
    'weight' => 'Gewicht',
    'job' => 'Beruf',
    'online' => 'online',
    'last_seen' => 'Zuletzt gesehen: :diff',
    'user_ignored' => 'Der Benutzer wurde vom Zielbenutzer ignoriert',
    'already_liked' => 'Du hast diesem Benutzer schon ein Like gegeben',
    'user_not_yet_liked' => 'Der Benutzer hat noch kein Like bekommen',
    'wait_until_back_liked' => 'Du musst warten, bis der Benutzer dir auch ein Like gegeben hat, bevor ihr Nachrichten austauschen könnt.',
    'like' => 'Like',
    'liked_successfully' => 'Du hast dem Mitglied ein Like gegeben',
    'unliked_successfully' => 'Du hast dein Like wieder zurückgenommen',
    'unignore' => 'Nicht mehr ignorieren',
    'ignored_successfully' => 'Der Benutzer wird nun ignoriert',
    'unignored_successfully' => 'Der Benutzer wurde von der Ignorier-Liste entfernt',
    'reported_successfully' => 'Mitglied erfolgreich gemeldet',
    'message_create' => 'Nachricht erstellen',
    'edit_profile' => 'Profil bearbeiten',
    'visitors' => 'Besucher',
    'security' => 'Sicherheit',
    'membership' => 'Mitgliedschaft',
    'ignore_list' => 'Ignorier-Liste',
    'user_visited_short' => 'Du hast einen neuen Besucher',
    'user_visited_long' => '<a href=":url">@:name</a> hat dein Profil besucht. <a href=":visitors">Mehr anzeigen</a>',
    'no_more_visitors' => 'Keine weiteren Besucher',
    'close' => 'Schließen',
    'realname' => 'Echter Name',
    'birthday' => 'Geburtstag',
    'introduction' => 'Beschreibung',
    'save' => 'Speichern',
    'profile_saved' => 'Profil wurde gespeichert',
    'invalid_username' => 'Der Name ist ungültig. Bitte nur alphabetische Zeichen, die Nummern 0-9 und die Zeichen \'-\' und \'_\' verwenden. Namen dürfen nicht ausschließlich aus Zahlen bestehen.',
    'username_already_in_use' => 'Der Benutzername ist schon vergeben',
    'photos' => 'Fotos',
    'password_saved' => 'Passwort erfolgreich gespeichert',
    'email_saved' => 'E-Mail Adresse erfolgreich gespeichert',
    'password_confirmation' => 'Passwort Bestätigung',
    'account_removal_hint' => 'Hier kannst du deinen Account löschen. Alle deine Daten werden gelöscht. Achtung: Dies kann nicht rückgängig gemacht werden!',
    'enter_keyphrase' => 'Gib die Zeichenfolge <i><font color="#f90000">:phrase</font></i> in das Textfeld ein und klicke dann auf den Button.',
    'delete' => 'Löschen',
    'invalid_keyphrase' => 'Ungültige Zeichenfolge angegeben',
    'account_deleted' => 'Konto wurde gelöscht',
    'mail_on_message' => 'E-Mail Benachrichtigung bei neuen privaten Nachrichten',
    'newsletter_notice' => 'Ich möchte über Neuigkeiten informiert werden',
    'notifications_saved' => 'Benachrichtigungseinstellungen erfolgreicht gespeichert',
    'select_photo' => 'Foto auswählen',
    'photo_saved' => 'Photo wurde gespeichert',
    'no_more_users' => 'Keine weiteren Nutzer',
    'cookie_notice' => 'Cookie Information',
    'cookie_close' => 'Akzeptieren und schließen',
    'login_failed' => 'Login fehlgeschlagen. Bitte überprüfe, ob du dein Passwort richtig angegeben hast. Du kannst auch dein Passwort zurücksetzen.',
    'like_back' => 'Gib ein Like, um einen Chat zu starten!',
    'next_profile' => 'Nächstes Profil',
    'mail_email_changed_title' => 'E-Mail geändert',
    'mail_salutation' => 'Hallo :name',
    'mail_email_changed_body' => 'Deine E-Mail Adresse wurde erfolgreich geändert. Deine neue Adresse ist: :email',
    'mail_message_received_title' => 'Neue Nachricht erhalten',
    'mail_message_received_info' => 'Du hast eine neue Nachricht erhalten',
    'mail_message_received_body' => 'Du hat eine neue Nachricht erhalten. Du kannst sie in deinem Postfach lesen.',
    'mail_message_open' => 'Nachricht öffnen',
    'mail_pw_changed_title' => 'Passwort geändert',
    'mail_pw_changed_body' => 'Dein Passwort wurde erfolgreich geändert',
    'mail_password_reset_title' => 'Passwort zurücksetzen',
    'mail_password_reset_body' => 'Es wurde angefordert, dein Passwort zurückzusetzen. Klick dazu auf den Link unten.',
    'mail_password_reset' => 'Passwort zurücksetzen',
    'mail_registered_title' => 'Willkommen bei ' . env('APP_NAME'),
    'mail_registered_body' => 'Willkommen bei ' . env('APP_NAME') . '! Bitte bestätige noch dein Konto über den Link unten.',
    'mail_registered_confirm' => 'Bestätigen',
    'both_not_liked' => 'Ihr müsst euch beide ein Like gegeben haben, um Nachrichten auszutauschen.',
    'unlike' => 'Like entfernen',
    'insufficient_permissions' => 'Unzureichende Berechtigungen',
    'about' => 'Über',
    'admin_area' => 'Admin Bereich',
    'background' => 'Hintergrund',
    'logo' => 'Logo',
    'cookie_consent' => 'Cookie consent',
    'reg_info' => 'Registration Info',
    'environment' => 'Environment',
    'users' => 'Benutzer',
    'features' => 'Features',
    'newsletter' => 'Newsletter',
    'reports' => 'Meldungen',
    'head_code' => 'Head Code',
    'adcode' => 'Ad Code',
    'about_headline' => 'Headline',
    'about_subline' => 'Subline',
    'about_description' => 'Beschreibung (HTML allowed)',
    'background_info' => 'Das Hintergrundbild',
    'logo_info' => 'Das Logo (PNG only)',
    'cookieconsent_description' => 'Inhalt des Cookie Consents (HTML allowed)',
    'reginfo_description' => 'Die Info, die im Registrierungsformular angegeben wird (HTML allowed)',
    'tos_description' => 'Der Inhalt der Nutzungsbedingungen (HTML allowed)',
    'imprint_description' => 'Das Impressum (HTML allowed)',
    'project_description' => 'Projekt Beschreibung',
    'project_tags' => 'Projekt Schlüsselwörter/Tags',
    'project_lang' => 'Globale Sprache',
    'project_keyphrase' => 'Keyphrase zur Kontolöschung',
    'project_maxuploadsize' => 'Maximale Upload Größe',
    'project_enableads' => 'Werbung aktivieren',
    'project_smtp_host' => 'SMTP Host',
    'project_smtp_user' => 'SMTP Benutzer',
    'project_smtp_pw' => 'SMTP Passwort',
    'project_smtp_fromname' => 'SMTP From-Name',
    'project_smtp_fromaddress' => 'SMTP From-Address',
    'project_twitter_news' => 'Twitter Handle für den News Feed',
    'project_helprealm_workspace' => 'HelpRealm Workspace',
    'project_helprealm_token' => 'HelpRealm Token',
    'project_helprealm_tickettypeid' => 'HelpRealm Ticket ID',
    'project_stripe_enable' => 'Stripe Zahlung aktivieren',
    'project_stripe_secret' => 'Stripe Secret',
    'project_stripe_public' => 'Stripe Public Token',
    'project_stripe_costs_value' => 'Stripe Kostenwert',
    'project_stripe_costs_label' => 'Stripe Kostenbezeichnung',
    'table_search' => 'Suchen',
    'table_show_entries' => 'Zeige Einträge',
    'table_row_info' => '',
    'table_pagination_prev' => 'Vorherige',
    'table_pagination_next' => 'Nächste',
    'refresh' => 'Aktualisieren',
    'feature_id' => 'ID',
    'feature_title' => 'Titel',
    'feature_description' => 'Beschreibung',
    'feature_last_updated' => 'Zuletzt aktualisiert',
    'remove' => 'Entfernen',
    'feature_remove' => 'Entfernen',
    'faq_id' => 'ID',
    'faq_question' => 'Frage',
    'faq_answer' => 'Antwort',
    'faq_last_updated' => 'Zuletzt aktualisiert',
    'faq_remove' => 'Entfernen',
    'report_id' => 'ID',
    'report_user' => 'Benutzername',
    'report_count' => 'Anzahl',
    'report_lock' => 'Sperren',
    'report_safe' => 'Als sicher markieren',
    'headcode_description' => 'Code, der in den HEAD-Bereich eingefügt wird',
    'adcode_description' => 'Code, der für Werbung genutzt wird',
    'confirm_delete' => 'Möchstest du mit dem Löschen wirklich fortfahren?',
    'get_user_details' => 'Benutzerdetails anzeigen',
    'data_saved' => 'Daten wurden erfolgreich gespeichert',
    'bg_alpha' => 'Hintergrund Alpha-Channel Wert',
    'invalid_image_file' => 'Ungültige Bild-Datei',
    'success' => 'Erfolg',
    'error' => 'Fehler',
    'not_a_png_file' => 'Die angegebene Datei ist kein PNG Bild',
    'user_not_found' => 'Der angegebene Benutzer wurde nicht gefunden',
    'reset_password' => 'Passwort zurücksetzen',
    'deactivated' => 'Deaktiviert',
    'admin' => 'Admin',
    'delete_account' => 'Konto löschen',
    'email_not_found' => 'E-Mail Adresse nicht gefunden',
    'user_not_found_or_deactivated' => 'Benutzer nicht gefunden oder deaktiviert',
    'feature_create' => 'Feature Item erstellen',
    'feature_saved' => 'Feature Item wurde gespeichert',
    'feature_removed' => 'Feature Item wurde gelöscht',
    'faq_saved' => 'FAQ Item wurde gespeichert',
    'faq_removed' => 'FAQ Item wurde gelöscht',
    'edit_feature' => 'Feature Item bearbeiten',
    'feature_remove_confirm' => 'Möchtest du dieses Item wirklich löschen?',
    'faq_create' => 'FAQ Item erstellen',
    'edit_faq' => 'FAQ Item bearbeiten',
    'faq_remove_confirm' => 'Möchtest du dieses Item wirklich löschen?',
    'report_confirm_lock' => 'Möchtest du diesen Benutzer sperren?',
    'report_confirm_safe' => 'Soll der Nutzer als sicher markiert werden?',
    'user_deactivated' => 'Benutzer wurde deaktiviert',
    'user_now_safe' => 'Nutzer wurde als bisher unbedenklich gesetzt',
    'report_reason' => 'Begründung',
    'newsletter_in_progress' => 'Der Newsletter wird jetzt verschickt',
    'mail_subject_register' => 'Konto Registrierung',
    'mail_password_reset_subject' => 'Passwort zurücksetzen',
    'password_changed' => 'Passwort geändert',
    'email_changed' => 'E-Mail Adresse geändert',
    'message_received' => 'Nachricht erhalten',
    'mail_footer' => 'Viele Grüße',
    'language' => 'Sprache',
    'geoexclude_notice' => 'Mein Profil in der Geo-Suche verstecken',
    'usernameOk' => 'The Benutzername ist gültig und noch frei',
    'invalidUsername' => 'Der Name ist ungültig. Bitte nur alphabetische Zeichen, die Nummern 0-9 und die Zeichen \'-\' und \'_\' verwenden. Namen dürfen nicht ausschließlich aus Zahlen bestehen.',
    'nonavailableUsername' => 'Der Benutzername ist schon vergeben',
    'passwordMismatching' => 'Die Passwörter stimmen nicht überein',
    'passwordMatching' => 'Die Passwörter stimmen überein',
    'isnew' => 'Neu',
    'removeIgnore' => 'Entfernen',
    'status' => 'Status',
    'logout_successful' => 'Du wurdest erfolgreich abgemeldet',
    'product_installed' => 'Das Produkt wurde installiert. Du kannst dich nun mit deiner E-Mail Adresse und dem folgende Passwort anmelden: ":password".',
    'contact_feature_disabled' => 'Die Kontakt-Funktion wurde deaktiviert',
    'contact_name' => 'Dein Name',
    'contact_email' => 'Deine E-Mail Adresse',
    'contact_subject' => 'Betreff',
    'contact_body' => 'Nachricht',
    'submit' => 'Absenden',
    'go_back' => 'Zurück',
    'confirm_verify_permission' => 'Ich bestätige, dass ich die Berechtigung habe, diese Daten zu senden',
    'verify_account_ok' => 'Deine Kontoverifizierung wird nun so schnell wie möglich bearbeitet.',
    'verify_permission_unconfirmed' => 'Du musst bestätigen, dass du die Bereichtigung hast, diese Daten zu senden',
    'verification_in_progress' => 'Deine Kontoverifizierung wird noch bearbeitet',
    'verification_succeeded' => 'Dein Konto ist verifizert!',
    'verify_account' => 'Konto verifizieren',
    'identity_card_front' => 'Ausweis Vorderseite',
    'identity_card_back' => 'Auweis Rückseite',
    'verify_id' => 'ID',
    'verify_user' => 'Name',
    'verify_idcard_front' => 'Ausweis Vorderseite',
    'verify_idcard_back' => 'Auweis Rückseite',
    'verify_approve' => 'Bewilligen',
    'verify_decline' => 'Ablehnen',
    'verification' => 'Verifizierung',
    'mail_acc_verify_title' => 'Konto Verifizierung',
    'mail_acc_verify_info' => 'Ergebnis der Kontoverifizierung',
    'mail_acc_verify_body' => 'Das Ergebnis deiner Kontoverifizierung ist wie folgt: :state - Begründung: :reason',
    'account_verified' => 'Die Verifizierung wurde bewilligt',
    'account_verification_declined' => 'Die Verifizierung wurde abgelehnt',
    'verified_profile' => 'Verifiziertes Profil',
    'new_message_short' => ':name hat dir eine Nachricht geschickt',
    'new_message' => ':name hat dir eine Nachricht geschickt: <a href=":url">:text</a>',
    'message_received' => 'Nachricht erhalten',
    'project_stripe_currency' => 'Währung',
    'payment_service_deactivated' => 'Zahlungsfunktion ist momentan deaktiviert',
    'user_not_found_or_locked_or_already_pro' => 'Benutzer nicht gefunden, deaktiviert oder hat bereits Pro-Modus aktiviert',
    'payment_failed' => 'Die Zahlung ist fehlgeschlagen',
    'payment_succeeded' => 'Die Zahlung war erfolgreich. Pro-Mode ist jetzt aktiviert',
    'promode_still_active' => 'Dein Pro-Modus ist noch für :days Tage aktiviert.',
    'purchase_pro_mode' => 'Pro-Modus kaufen',
    'buy_pro_mode_title' => 'Pro-Modus kaufen',
    'buy_pro_mode_info' => 'Hier kannst du Pro-Modus kaufen. Dies führt zu Folgendem:<br/><ul><li>Dir wird keine Werbung mehr angezeigt</li><li>Du unterstützt den Betrieb des Dienstes</li></ul><br/>Es kostet dich nur <strong>:costs</strong> und der Modus wird für :days Tage aktiviert bleiben.',
    'credit_or_debit_card' => 'Kredit- oder Debit-Karte',
    'submit_payment' => 'Zahlung durchführen',
    'welcome_dashboard' => 'Hallo :name',
    'dashboard_find_members' => 'Finde jetzt <a href=":url"><strong>Mitglieder</strong></a> in deiner Nähe.',
    'dashboard_new_visitors' => 'Du hast <a href=":url"><strong>:count</strong></a> neue Profilbesucher.',
    'dashboard_new_messages' => 'Du hast <a href=":url"><strong>:count</strong></a> ungelesene Nachrichten.',
    'dashboard_verified' => 'Super! Du hast ein verifiziertes Profil!',
    'dashboard_not_verified' => 'Du hast noch kein verifiziertes Profil. Du kannst es <a href=":url"><strong>hier</strong></a> verifizieren.',
    'dashboard_verification_inprogress' => 'Die Verifizierung deines Profiles wird bearbeitet.',
    'dashboard_declined' => 'Die Verifizierung deines Profiles wurde abgelehnt. Du kannst die Verifizierung <a href=":url"><strong>hier</strong></a> erneut beantragen.',
    'dashboard_promode_active' => 'Pro-Modus ist aktiv! Dein Pro-Modus ist noch :days Tage aktiv.',
    'dashboard_promode_not_active' => 'Pro-Modus ist nicht aktiv! Du kannst ihn <a href=":url"><strong>hier</strong></a> kaufen!',
    'register_welcome_short' => 'Willkommen bei ' . env('APP_NAME') . '!',
    'register_welcome_long' => 'Willkommen bei ' . env('APP_NAME') . '. Bitte aktualisiere noch <a href=":url">deine Profilinformationen</a>, damit andere mehr über dich erfahren können. Viel Spaß!',
    'no_notifications_yet' => 'Noch keine Benachrichtigungen',
    'likes' => 'Likes',
    'received_likes' => 'Erhalten',
    'given_likes' => 'Gegeben',
    'like_received_short' => 'Du hast ein Like erhalten',
    'like_received_long' => '<a href=":url_profile">@:name</a> hat dir ein Like dagelassen. <a href=":url_settings">Alle anzeigen</a>',
    'view_profile' => 'Profil anzeigen',
    'delete_photo' => 'Löschen',
    'photo_deleted' => 'Das Foto wurde gelöscht',
    'orientation' => 'Sexuelle Orientierung',
    'orientation_hetero' => 'Heterosexuell',
    'orientation_bi' => 'Bisexuell',
    'orientation_homo' => 'Homosexuell',
    'gender_unspecified' => 'Unspecified',
    'no_more_messages' => 'Keine weiteren Nachrichten',
    'add_favorite' => 'Favorit',
    'remove_favorite' => 'Un-Favorit',
    'added_to_favorites' => 'Zu Favoriten hinzugefügt',
    'removed_from_favorites' => 'Von Favoriten entfernt',
    'favorites' => 'Favoriten',
    'no_favorites_yet' => 'Noch keine Favoriten hinzugefügt',
    'user_not_receiving_messages' => 'Die Nachricht konnte nicht zugestellt werden',
    'approvals' => 'Bewilligungen',
    'approval_id' => 'ID',
    'approval_user' => 'Benutzer',
    'approval_photo' => 'Foto',
    'approve' => 'Bewilligen',
    'approve_all' => 'Alle bewilligen',
    'decline' => 'Ablehnen',
    'decline_all' => 'Alle ablehnen',
    'approval_approved_short' => 'Dein Foto wurde akzeptiert',
    'approval_approved_long' => 'Dein Foto wurde akzeptiert',
    'approval_declined_short' => 'Dein Foto wurde abgelehnt',
    'approval_declined_long' => 'Dein Photo wurde abgelehnt',
    'photo_approved' => 'Das Foto wurde akzeptiert',
    'photo_declined' => 'Das Foto wurde abgelehnt',
    'geo_required' => 'Du musst die Positionsdienste aktivieren, um diese Seite zu sehen.',
    'register_captcha_invalid' => 'Der eingegebene Captcha war ungültig. Bitte erneut probieren.',
    'passwords_mismatch' => 'Die Passwörter stimmen nicht überein',
    'register_email_in_use' => 'Die angegebene E-Mail Adresse wird bereits verwendet.',
    'register_username_in_use' => 'Der angegebene Benutzername ist schon vergeben.',
    'register_username_invalid_chars' => 'Der angegebene Benutzername enthält ungültige Zeichen.',
    'account_not_yet_confirmed' => 'Bitte bestätige erst dein Konto. <a href=":url">Bestätigungslink erneut anfordern</a>',
    'back' => 'Zurück',
    'register_birthday' => 'Geburtstag',
    'register_min_age' => 'Du musst mindestens :min Jahre alt sein, um dich registrieren zu dürfen.',
    'settings_min_age' => 'Du darfst nicht jünger als :min Jahre alt sein.',
    'guestbook' => 'Gästebuch',
    'guestbook_entry_short' => 'Neuer Eintrag im Gästebuch',
    'guestbook_entry_long' => '<a href=":url">@:name</a> hat einen neuen Eintrag in deinem Gästebuch verfasst',
    'user_guestbook_ignored' => 'Fehler beim Übermitteln des Gästebuch Eintrages.',
    'guestbook_entry_added' => 'Der Eintrag wurde in das Gästebuch hinzugefügt',
    'no_more_entries_found' => 'Keine weiteren Einträge gefunden',
    'guestbook_item_deleted' => 'Der Eintrag wurde gelöscht',
    'enable_guestbook' => 'Mein Gästebuch aktivieren',
    'edit_guestbook_entry' => 'Eintrag des Gästebuches bearbeiten',
    'guestbook_entry_updated' => 'Der Eintrag wurde aktualisiert',
    'edit' => 'Bearbeiten',
    'edited' => 'Bearbeitet',
    'info_profile_visit' => 'Benachrichtigung erhalten bei neuen Profilbesuchern',
    'online_user_count' => 'Es sind gerade :count Mitglieder online',
    'tab_scroll_hint' => 'Hinweis: Du kannst das nachfolgende Menu nach rechts und links scrollen',
    'events' => 'Veranstaltungen',
    'name' => 'Name',
    'dateOfEvent' => 'Datum',
    'description' => 'Beschreibung',
    'event_create' => 'Veranstaltung erstellen',
    'event_edit' => 'Veranstaltung bearbeiten',
    'event_created' => 'Veranstaltung wurde erstellt.',
    'event_edited' => 'Veranstaltung wurde aktualisiert.',
    'event_not_found' => 'Veranstaltung konnte nicht gefunden werden',
    'confirm_delete_event' => 'Soll diese Veranstaltung wirklich gelöscht werden?',
    'participants' => 'Teilnehmende',
    'interested' => 'Interessierte',
    'no_participants_yet' => 'Keine Teilnehmenden bisher',
    'no_interested_yet' => 'Noch niemand interessiert',
    'comments' => 'Kommentare',
    'no_more_comments' => 'Keine weiteren Kommentare',
    'comment_saved' => 'Kommentar wurde gespeichert',
    'comment_updated' => 'Kommentar wurde aktualisiert',
    'comment_deleted' => 'Kommentar wurde gelöscht',
    'now_participating' => 'Du nimmst nun teil!',
    'now_not_participating_anymore' => 'Du nimmst nicht mehr teil',
    'now_interested' => 'Du hast dich als Interessierten markiert',
    'now_not_interested_anymore' => 'Du bist nun nicht mehr interessiert',
    'do_participate' => 'Teilnehmen',
    'do_set_interested' => 'Ich bin interessiert',
    'no_participating_anymore' => 'Nicht mehr teilnehmen',
    'not_interested_anymore' => 'Kein Interesse mehr',
    'event_id' => 'ID',
    'event_name' => 'Name',
    'event_owner' => 'Besitzer',
    'event_approved' => 'Veranstaltung wurde bewilligt',
    'event_declined' => 'Veranstaltung wurde abgelehnt',
    'no_more_events' => 'Keine weiteren Veranstaltungen',
    'not_approved_yet' => 'Veranstaltung wurde noch nicht freigeschaltet',
    'image_posted' => 'Das Bild wurde gepostet',
    'send_image' => 'Bild senden',
    'announcements' => 'Ankündigungen',
    'title' => 'Titel',
    'content' => 'Inhalt (HTML erlaubt)',
    'until' => 'Bis wann anzeigen',
    'announcement_created' => 'Ankündigung wurde erstellt',
    'dashboard_event_count' => 'Es werden derzeit <a href=":url"><b>:count</b></a> Veranstaltungen geplant.',
    'events_about' => 'Hier kannst du Veranstaltungen sehen oder erstellen. Veranstaltungen sind nützlich, um andere Benutzer:innen zu treffen. Gehe auf eine Veranstaltung, um Details anzusehen und Aktionen auszuführen.',
    'message_not_found' => 'Die Nachricht konnte nicht gefunden werden',
    'enter_report_reason' => 'Bitte gib den Grund an, weshalb du das Mitglied meldest.',
    'theme' => 'Theme',
    'settings_photos_hint' => 'Klicke oder tippe auf ein Foto, um es zu ersetzen.',
    'forum' => 'Forum',
    'forum_title' => 'Forum',
    'forum_subtitle' => 'Nimm an Diskussionen teil. Jede Diskussion bezieht sich auf ein bestimmtes Themengebiet',
    'search_for_name' => 'Name suchen',
    'search' => 'Suchen',
    'forums_no_forums_found' => 'Keine weitere Foren gefunden',
    'forum_not_found_or_locked' => 'Das angegebene Forum wurde entweder nicht gefunden oder ist gesperrt',
    'forums_no_threads_found' => 'Keine weiteren Beiträge gefunden',
    'thread_not_found_or_locked' => 'Der angegebene Beitrag wurde entweder nicht gefunden oder ist gesperrt',
    'thread' => 'Beitrag',
    'forums_no_posts_found' => 'Keine weiteren Postings gefunden',
    'thread_created' => 'Neuer Beitrag wurde erfolgreich erstellt',
    'create_thread' => 'Beitrag erstellen',
    'title' => 'Titel',
    'enter_title' => 'Gib einen Titel ein',
    'message' => 'Nachricht',
    'enter_message' => 'Gib hier deine Nachricht ein',
    'thread_replied' => 'Antwort erstellt',
    'set_thread_sticky' => 'Den Beitrag anheften',
    'thread_edited' => 'Beitrag wurde aktualisiert',
    'edit_thread' => 'Beitrag bearbeiten',
    'set_thread_locked' => 'Beitrag sperren',
    'thread_not_found_or_locked' => 'Beitrag wurde nicht gefunden oder ist gesperrt',
    'no_reply_to_locked_thread' => 'Dieser Beitrag wurde gesperrt',
    'search_for_thread' => 'Suche nach Beitrag',
    'forum_post_reported' => 'Forum-Posting wurde gemeldet',
    'forum_post_not_found_or_locked' => 'Forum-Posting nicht gefunden oder gesperrt',
    'single_post' => 'Einzelnen Beitrag ansehen',
    'confirmLockForumPost' => 'Möchtest du dieses Posting sperren?',
    'forum_post_locked' => 'Dieser Beitrag wurde gesperrt',
    'forum_post_locked_ok' => 'Der Post wurde gesperrt',
    'forum_post_edited' => 'Posting wurde aktualisiert',
    'forum_post_edited_info' => 'Aktualisiert',
    'forums' => 'Foren',
    'forum_id' => 'ID',
    'forum_name' => 'Name',
    'forum_description' => 'Beschreibung',
    'forum_lock' => 'Sperren',
    'forum_remove' => 'Löschen',
    'forum_created' => 'Forum wurde erstellt',
    'forum_create' => 'Forum erstellen',
    'forum_edited' => 'Forum wurde aktualisiert',
    'forum_locked' => 'Forum wurde gesperrt',
    'forum_removed' => 'Forum wurde gelöscht',
    'forum_edit' => 'Forum bearbeiten',
    'forum_reply_short' => 'Neue Antwort im Forum',
    'forum_reply_long' => ':name hat auf einen Forenbeitrag geantwortet: <a href=":url">:thread</a>',
    'go_back' => 'Zurück',
    'forum_remove_confirm' => 'Soll diese Forenrubrik wirklich gelöscht werden?',
    'lock' => 'Sperren',
    'load_more' => 'Mehr laden',
    'reply' => 'Antworten',
    'reply_thread' => 'Auf Diskussion antworten',
    'forumPostEdited' => 'Editiert: '
];