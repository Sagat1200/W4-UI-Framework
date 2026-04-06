import { readFile, writeFile } from 'node:fs/promises';
import { resolve } from 'node:path';

const files = [
  {
    path: resolve(process.cwd(), 'resources/dist/css/w4-daisyui.css'),
    from: /\.w4-scope\b/g,
    to: '.w4-scope-daisy',
  },
  {
    path: resolve(process.cwd(), 'resources/dist/css/w4-tailwind.css'),
    from: /\.w4-scope\b/g,
    to: '.w4-scope-tailwind',
  },
];

for (const file of files) {
  const content = await readFile(file.path, 'utf8');
  const updated = content.replace(file.from, file.to);
  await writeFile(file.path, updated, 'utf8');
}
