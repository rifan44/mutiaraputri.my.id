<?php

namespace App\Controllers;

use App\Libraries\PortfolioData;
use Dompdf\Dompdf;
use Dompdf\Options;

class Export extends BaseController
{
    public function cv(string $locale): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->renderDocument($locale, false);
    }

    public function portfolio(string $locale): \CodeIgniter\HTTP\ResponseInterface
    {
        return $this->renderDocument($locale, true);
    }

    private function renderDocument(string $locale, bool $fullPortfolio): \CodeIgniter\HTTP\ResponseInterface
    {
        if (! in_array($locale, ['id', 'en'], true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = PortfolioData::load();
        $data['locale'] = $locale;
        $data['fullPortfolio'] = $fullPortfolio;
        $data['profile']['avatar_data'] = $this->imageDataUri($data['profile']['avatar_path'] ?? null);

        foreach ($data['projects'] as &$project) {
            $project['image_data'] = $this->imageDataUri($project['image_path'] ?? null);
        }
        unset($project);

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->setChroot(FCPATH);

        $pdf = new Dompdf($options);
        $pdf->loadHtml(view('exports/document', $data), 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $name = url_title($data['profile']['full_name'] ?? 'mutiara-putri', '-', true);
        $kind = $fullPortfolio ? 'portfolio' : 'cv';
        $filename = $kind . '-' . ($name ?: 'mutiara-putri') . '-' . strtoupper($locale) . '.pdf';

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'private, no-store, max-age=0')
            ->setBody($pdf->output());
    }

    private function imageDataUri(?string $relativePath): ?string
    {
        if (! $relativePath || ! str_starts_with($relativePath, 'uploads/')) {
            return null;
        }

        $fullPath = realpath(FCPATH . $relativePath);
        $publicRoot = realpath(FCPATH);

        if (! $fullPath || ! $publicRoot || ! str_starts_with($fullPath, $publicRoot . DIRECTORY_SEPARATOR) || ! is_file($fullPath)) {
            return null;
        }

        $mime = mime_content_type($fullPath);
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }

        return 'data:' . $mime . ';base64,' . base64_encode((string) file_get_contents($fullPath));
    }
}
