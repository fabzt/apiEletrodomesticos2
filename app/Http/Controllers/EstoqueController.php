<?php

namespace App\Http\Controllers;

use App\Models\Estoque; // Certifique-se que o nome do modelo está correto (geralmente é no singular: 'Estoque')
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todos os registros do modelo Estoque
        $registros = Estoque::all();

        // Contando o número de registros
        $contador = $registros->count();

        // Verificando se há registros
        if ($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Itens do estoque encontrados com sucesso',
                'data' => $registros,
                'total' => $contador
            ], 200);
        }

        // Caso não haja registros, retornar 404
        return response()->json([
            'success' => false,
            'message' => 'Nenhum item encontrado no estoque',
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos (ajuste os campos conforme seu modelo 'Estoque')
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'fornecedor' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        // Criando um registro no banco de dados
        $registro = Estoque::create($request->all());

        if ($registro) {
            return response()->json([
                'success' => true,
                'message'=> 'Item cadastrado no estoque com sucesso!',
                'data' => $registro
            ], 201);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar o item no estoque'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscando um item do estoque pelo ID
        $registro = Estoque::find($id);

        // Verificando se o item foi encontrado
        if ($registro) {
            return response()->json([
                'success' => true,
                'message' => 'Item localizado com sucesso!',
                'data' => $registro
            ], 200);
        } 
        
        return response()->json([
            'success' => false,
            'message' => 'Item não localizado no estoque.',
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos (ajuste os campos conforme seu modelo 'Estoque')
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'fornecedor' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        // Encontrando o registro no banco
        $registro = Estoque::find($id);

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Item não encontrado no estoque'
            ], 404);
        }

        // Atualizando os dados do registro com os dados da requisição
        $registro->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Item do estoque atualizado com sucesso!',
            'data' => $registro
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrando um item no banco
        $registro = Estoque::find($id);

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Item não encontrado no estoque'
            ], 404);
        }

        // Deletando o item
        if ($registro->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Item deletado do estoque com sucesso'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar o item do estoque'
        ], 500);
    }
}
