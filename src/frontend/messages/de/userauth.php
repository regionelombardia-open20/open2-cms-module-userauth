<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   amos\cms-module-userauth
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

return [
    '#password_rules' => 'La password deve contenere almeno: 8 caratteri, 1 o più lettere maiuscole e minuscole, 1 numero e 1 carattere speciale (!@#$%^&*)',
    '#first_access_fill_the_form' => 'Compila i seguenti campi per scegliere le tue credenziali di accesso alla piattaforma',

    '#title_reset_password' => 'Reset password',
    '#reset_password' => 'Aggiornamento password',
    '#reset_password_fill_the_form' => 'Compila i seguenti campi per aggiornare la password',

    '#cookie_policy_ok' => 'Ich bestätige die Bestätigung',
    'userauth.propertie.userauthprotection.label' => 'Benutzer-Authentifizierung aktivieren',
    'userauth.models.user.username' => 'Benutzername',
    'userauth.models.user.password' => 'Passwort',
    'userauth.models.user.password_salt' => 'Passwort salt',
    'userauth.controller.default.index.loginlabel' => 'Anmelden',
    'userauth.models.userloginform.error.username_password' => 'Benutzername und/oder Passwort falsch',
    'userauth.models.userloginform.error.username_not_active' => 'Benutzer nicht aktiv',
    '#role_permissions_propety_label' => 'Permissions',
];
