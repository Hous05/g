<?php

namespace App\Controllers;

use App\Models\HealthModel;
use App\Models\ObjectiveModel;
use App\Models\ProgramModel;

class Program extends BaseController
{
    public function objective()
    {
        $userId = $this->requireUser();
        $durationDays = (int) ($this->session->get('objective_duration_days') ?? 30);

        if (strtolower($this->request->getMethod()) === 'post') {
            $postedDuration = trim((string) $this->request->getPost('duree_jours'));
            if ($postedDuration !== '') {
                $postedDurationDays = (int) $postedDuration;
                if ($postedDurationDays > 0) {
                    $durationDays = $postedDurationDays;
                    $this->session->set('objective_duration_days', $durationDays);
                }
            }

            (new HealthModel())->setObjective(
                $userId,
                (int) $this->request->getPost('objectif_id'),
                $this->request->getPost('poids_cible_kg') !== '' ? (float) $this->request->getPost('poids_cible_kg') : null
            );
        }

        return view('front/program/objective', [
            'title' => 'Objectif',
            'objectives' => (new ObjectiveModel())->orderBy('id')->findAll(),
            'profile' => (new HealthModel())->findByUser($userId),
            'durationDays' => $durationDays,
        ]);
    }

    public function detail()
    {
        $userId = $this->requireUser();
        $programModel = new ProgramModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $postedDuration = trim((string) $this->request->getPost('duree_jours'));
            $durationDays = $postedDuration !== ''
                ? (int) $postedDuration
                : (int) ($this->session->get('objective_duration_days') ?? 30);

            $programModel->createProgram(
                $userId,
                (int) $this->request->getPost('regime_id'),
                (int) $this->request->getPost('activite_id'),
                $durationDays
            );
        }

        return view('front/program/detail', [
            'title' => 'Programme',
            'program' => $programModel->latestForUser($userId),
        ]);
    }

    public function export()
    {
        $userId = $this->requireUser();
        $program = (new ProgramModel())->latestForUser($userId);

        if (!$program) {
            return redirect()->to(site_url('program'));
        }

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Regime Alimentaire');
        $pdf->SetAuthor('Regime Alimentaire');
        $pdf->SetTitle('Programme alimentaire');
        $pdf->SetMargins(15, 18, 15);
        $pdf->SetAutoPageBreak(true, 18);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 11);

        $html = view('front/program/export', [
            'program' => $program,
        ]);

        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = 'programme_' . date('Ymd_His') . '.pdf';
        $pdfContent = $pdf->Output($fileName, 'S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setBody($pdfContent);
    }

    private function requireUser(): int
    {
        if (!$this->session->get('user_id')) {
            redirect()->to(site_url('login'))->send();
            exit;
        }

        return (int) $this->session->get('user_id');
    }
}