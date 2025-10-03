<?php

namespace App\Http\Controllers;

use App\Models\Estoque; // Renomeie seu modelo de 'Produtos' para 'Estoque' para seguir a convenção
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
        // Validação dos dados com base na sua migration
        $validator = Validator::make($request->all(), [
            'nomeprod' => 'required|string|max:255',
            'marcaprod' => 'required|string|max:255',
            'descprod' => 'required|string',
            'qtdprod' => 'required|integer',
            'dtentradaprod' => 'required|date',
            'dtsaidaprod' => 'nullable|date', // 'nullable' pois a data de saída pode não existir na criação
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
        // Encontrando o registro no banco ANTES de validar
        $registro = Estoque::find($id);

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Item não encontrado no estoque'
            ], 404);
        }

        // Validação dos dados para atualização
        $validator = Validator::make($request->all(), [
            'nomeprod' => 'required|string|max:255',
            'marcaprod' => 'required|string|max:255',
            'descprod' => 'required|string',
            'qtdprod' => 'required|integer',
            'dtentradaprod' => 'required|date',
            'dtsaidaprod' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 400);
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
