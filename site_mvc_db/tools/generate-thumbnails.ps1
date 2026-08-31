param(
    [int]$MaxSide = 900,
    [int]$Quality = 82
)

$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.Drawing

$projectRoot = Resolve-Path (Join-Path $PSScriptRoot '..')
$sourceDirs = @(
    (Join-Path $projectRoot 'public/images/uploads'),
    (Join-Path $projectRoot 'storage/uploads')
)
$targetDir = Join-Path $projectRoot 'public/images/thumbnails'

if (-not (Test-Path -LiteralPath $targetDir)) {
    New-Item -ItemType Directory -Path $targetDir | Out-Null
}

$jpegCodec = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() |
    Where-Object { $_.MimeType -eq 'image/jpeg' } |
    Select-Object -First 1

$encoderParameters = New-Object System.Drawing.Imaging.EncoderParameters(1)
$encoderParameters.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter(
    [System.Drawing.Imaging.Encoder]::Quality,
    [long]$Quality
)

$supportedExtensions = @('.jpg', '.jpeg', '.png', '.gif')
$created = 0
$skipped = 0

foreach ($sourceDir in $sourceDirs) {
    if (-not (Test-Path -LiteralPath $sourceDir)) {
        continue
    }

    Get-ChildItem -LiteralPath $sourceDir -File | Where-Object {
        $supportedExtensions -contains $_.Extension.ToLowerInvariant()
    } | ForEach-Object {
        $sourceFile = $_
        $targetFile = Join-Path $targetDir ($sourceFile.BaseName + '.jpg')

        if ((Test-Path -LiteralPath $targetFile) -and
            ((Get-Item -LiteralPath $targetFile).LastWriteTimeUtc -ge $sourceFile.LastWriteTimeUtc)) {
            $script:skipped++
            return
        }

        $image = $null
        $bitmap = $null
        $graphics = $null

        try {
            $image = [System.Drawing.Image]::FromFile($sourceFile.FullName)
            $ratio = [Math]::Min($MaxSide / $image.Width, $MaxSide / $image.Height)
            $ratio = [Math]::Min($ratio, 1)
            $targetWidth = [Math]::Max(1, [int][Math]::Round($image.Width * $ratio))
            $targetHeight = [Math]::Max(1, [int][Math]::Round($image.Height * $ratio))

            $bitmap = New-Object System.Drawing.Bitmap($targetWidth, $targetHeight)
            $bitmap.SetResolution($image.HorizontalResolution, $image.VerticalResolution)
            $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
            $graphics.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality
            $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
            $graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
            $graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
            $graphics.Clear([System.Drawing.Color]::Black)
            $graphics.DrawImage($image, 0, 0, $targetWidth, $targetHeight)

            $bitmap.Save($targetFile, $jpegCodec, $encoderParameters)
            $script:created++
        } catch {
            Write-Warning "Miniature ignoree: $($sourceFile.FullName) ($($_.Exception.Message))"
        } finally {
            if ($graphics) { $graphics.Dispose() }
            if ($bitmap) { $bitmap.Dispose() }
            if ($image) { $image.Dispose() }
        }
    }
}

Write-Output "Miniatures creees: $created"
Write-Output "Miniatures deja a jour: $skipped"
Write-Output "Dossier: $targetDir"
