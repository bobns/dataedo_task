<!-- Z Kodu wynika, że mamy doczynienia z kontrolerem (wskazują na to response). Na początek proponowałbym budowę modułową, która umożliwia lepsze skalowanie aplikacji.
Zatem  w katalogu app w Laravelu dodałbym folder Users jako moduł i zarejestrowałbym routing web.php w RouteServiceProvidera.
W web.php niezbędne jest dodanie routingu dla poniższych akcji w kontrolerze  -->

<?

public function updateUsers($users) // brakuje Requesta z walidacją (zatem utworzyłbym plik UpdateRequest extendujący po klasie Request z regułami walidacji)
{
	foreach ($users as $user) { //$users trzeba pobrać z requesta np. $request->input('users')
		try {
			if ($user['name'] && $user['login'] && $user['email'] && $user['password'] && strlen($user['name']) >= 10) // Taka walidacja sprawia, że kod jest nieczytelny i trudny w utrzymaniu. Walidacje proponuję umieścić w metodzie rules w requeście
				DB::table('users')->where('id', $user['id'])->update([
					'name' => $user['name'],
					'login' => $user['login'],
					'email' => $user['email'],
					'password' => md5($user['password'])
				]); // Laravel to framework MVC więc sugerowałbym skorzystać z model User. Ponadto utworzenie usera przeniósłbym do osobnego serwisu UserService, gdyż kontroler powinien się zajmować delegowaniem akcji a cała logika powinna być zawarta w odpowiednio przeznaczonych do tego klasach/serwisach
		} catch (\Throwable $e) {
			return Redirect::back()->withErrors(['error', ['We couldn\'t update user: ' . $e->getMessage()]]); // W przypadku złapania exceptiona nie należy wyświetlać użytkownikowi technicznych aspektów błędu, gdyż zawsze istnieje ryzyko zagrożenia dla bezpieczeństwa. Proponuje zalogować błąd a użytkownikowi wyświetlić informację w stylu something went wrong on server side, please try then later.
		}
	}
	return Redirect::back()->with(['success', 'All users updated.']);
}

public function storeUsers($users)
{

    foreach ($users as $user) {
        try {
			if ($user['name'] && $user['login'] && $user['email'] && $user['password'] && strlen($user['name']) >= 10)
				DB::table('users')->insert([
					'name' => $user['name'],
					'login' => $user['login'],
					'email' => $user['email'],
					'password' => md5($user['password'])
            ]);
        } catch (\Throwable $e) {
            return Redirect::back()->withErrors(['error', ['We couldn\'t store user: ' . $e->getMessage()]]);
        }
    }
    // Analogiczne błędy jak przy update Users, czyli brak Requesta z walidacja, i przekazywanie technicznego błędu do widoku.
    $this->sendEmail($users); // Wysyłanie maila to osobna funkcjonalność, którą przeniósłbym do osobnego modułu i serwisu. Same wywołanie metody przeniósłbym do foreacha z pojedynczym userem żeby nie duplikować kodu. 
    return Redirect::back()->with(['success', 'All users created.']);
}

private function sendEmail($users) // Tę metodę przeniósłbym do serwisu w osobnym module z pojedycznym userem, który jest modelem a nie zestawem danych z requesta
{
    foreach ($users as $user) {
        $message = 'Account has beed created. You can log in as <b>' . $user['login'] . '</b>';
        if ($user['email']) {
            Mail::to($user['email'])
                ->cc('support@company.com')
                ->subject('New account created')
                ->queue($message);
        }
    }
    return true; // Tutaj return jest niepotrzebny
}

?>