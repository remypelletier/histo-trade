export async function GET(request: Request) {
  const { searchParams } = new URL(request.url);
  const url = searchParams.get('url');

  const promise = await fetch(url);
  const data = await promise.json();

  return Response.json({ ...data });
}
