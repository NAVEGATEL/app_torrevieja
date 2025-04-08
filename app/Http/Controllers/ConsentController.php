namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsentController extends Controller
{
    public function submit(Request $request)
    {
        // Aquí puedes guardar los datos o generar un PDF, etc.
        // dd($request->all());

        return redirect()->back()->with('success', 'Formulario enviado correctamente.');
    }
}
